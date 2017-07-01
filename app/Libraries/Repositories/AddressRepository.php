<?php

namespace App\Libraries\Repositories;

use App\Models\Address;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;

class AddressRepository
{

	/**
	 * Returns all Addresses
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Address::all();
	}

	public function search($input)
    {
        $query = Address::query();

        $columns = Schema::getColumnListing('addresses');
        $attributes = array();

        foreach($columns as $attribute){
            if(!empty($input[$attribute]))
            {
                $query->where($attribute, $input[$attribute]);
                $attributes[$attribute] =  $input[$attribute];
            }else{
                $attributes[$attribute] =  null;
            }
        };

        return [$query, $attributes];

    }

	/**
	 * Stores Address into database
	 *
	 * @param array $input
	 *
	 * @return Address
	 */
	public function store($input)
	{
		return Address::create($input);
	}

	/**
	 * Find Address by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Address
	 */
	public function findAddressById($id)
	{
		return Address::find($id);
	}

	/**
	 * Updates Address into database
	 *
	 * @param Address $address
	 * @param array $input
	 *
	 * @return Address
	 */
	public function update($address, $input)
	{
		$address->fill($input);
		$address->save();

		return $address;
	}
	/**
	 * Save multiple Address into database
	 *
	 * @param Address[] $addressList
	 * @param array $input
	 *
	 * @return true on success
	 */
	public function saveAddresses($reference_id, $reference_type, $addressLists)
	{
 		if (empty($reference_id)) {
			throw new InvalidArgumentException("Invalid reference id");
		}
		if (!in_array($reference_type, Address::$reference_types)) {
			throw new InvalidArgumentException("Invalid reference type");
		}
		$upCount = 0;
		$inCount = 0;
		foreach ($addressLists as $key => $addressList) {
			// $lat_long = $this->getLatlong($addressList);
			$lat_long = [12.34,56.78];
			if($lat_long){
				list($lat, $long) = $lat_long;
			}else{
				unset($addressLists[$key]);
				continue;
			}
            $addressLists[$key]['reference_id'] = $reference_id;
            $addressLists[$key]['reference_type'] = $reference_type;
            $addressLists[$key]['created_at'] = date('Y-m-d H:i:s');
            $addressLists[$key]['updated_at'] = date('Y-m-d H:i:s');
            
            $addressLists[$key]['lat'] = $lat;
            $addressLists[$key]['long'] = $long;
            if (isset($addressLists[$key]['id']) 
            	&& !empty($addressLists[$key]['id'])) {
            	Address::where('id', $addressLists[$key]['id'])
            		->update($addressLists[$key]);
        		unset($addressLists[$key]);
            	$upCount++;
            }
		}
		// dd($addressLists);
		if (count($addressLists) > 0) {
			Address::insert($addressLists);
			$inCount++;
		}
		if($upCount > 0 || $inCount > 0){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Set Address From lat-Long
	 *
	 * @param int $reference_id
	 * @param string $reference_type
	 * @param float $lat
	 * @param float $long
	 * @return true on success
	 */
	public function saveAddressesFromLatLong($reference_id, $reference_type, $lat, $long)
	{
		if(empty($lat) || empty($long)){
			return false;
		}
		$address = $this->Get_Address_From_Google_Maps($lat, $long);
		if (empty($address)) {
			return false;
		}
        $address['reference_id'] = $reference_id;
        $address['reference_type'] = $reference_type;
        $address['created_at'] = date('Y-m-d H:i:s');
        $address['updated_at'] = date('Y-m-d H:i:s');
		return Address::insert($address);
	}


	/**
	* get lat long from full address
	*/
	private function getLatlong($addressArray){
		// dd(implode(' ', $addressArray));

		if (empty($addressArray)) {
			// throw new InvalidArgumentException("Missing param address");
			return false;
		}
		try{
			$address_srting = urlencode(implode(' ,', $addressArray));
			$fullurl = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address_srting."&sensor=true";
			$string = @file_get_contents($fullurl); // get json content
			$json_a = json_decode($string, true); //json decoder

			$lat = $json_a['results'][0]['geometry']['location']['lat']; // get lat for json
			$long = $json_a['results'][0]['geometry']['location']['lng']; // get ing for json
			if (empty($lat) || empty($long)) {
				// throw new InvalidArgumentException("Invalid address");
				return false;
			}
			return [$lat,$long];

		}
		catch(\Exception $e){
			return false;
		}
	}


	/**
	* get full address from lat long
	*/

	/** 
	* Given longitude and latitude in North America, 
	* @return the address using The Google Geocoding API V3
	*
	*/

	function Get_Address_From_Google_Maps($lat, $lon) {
		$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";
		// Make the HTTP request
		$data = @file_get_contents($url);
		// Parse the json response
		$jsondata = json_decode($data,true);

		// If the json data is invalid, return empty array
		if (!$this->check_status($jsondata))   return array();

		$address = array(
			'lat' => $lat,
			'long' => $lon,
		    'country' => $this->google_getCountry($jsondata),
		    'state' => $this->google_getProvince($jsondata),
		    'city' => $this->google_getCity($jsondata),
		    'address1' => $this->google_getStreet($jsondata),
		    'pincode' => $this->google_getPostalCode($jsondata),
		    // 'country_code' => $this->google_getCountryCode($jsondata),
		    // 'address1' => $this->google_getAddress($jsondata),
		);
		// dd($address);
		return $address;
	}

	/* 
	* Check if the json data from Google Geo is valid 
	*/

	function check_status($jsondata) {
	    if ($jsondata["status"] == "OK") return true;
	    return false;
	}

	/*
	* Given Google Geocode json, 
	* return the value in the specified element of the array
	*/

	function google_getCountry($jsondata) {
	    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
	}
	function google_getProvince($jsondata) {
	    return $this->Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
	}
	function google_getCity($jsondata) {
	    return $this->Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
	}
	function google_getStreet($jsondata) {
	    return $this->Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . $this->Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
	}
	function google_getPostalCode($jsondata) {
	    return $this->Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
	}
	function google_getCountryCode($jsondata) {
	    return $this->Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
	}
	function google_getAddress($jsondata) {
	    return $jsondata["results"][0]["formatted_address"];
	}

	/*
	* Searching in Google Geo json, 
	* @return the long name given the type. 
	* (If short_name is true, return short name)
	*/

	function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
	    foreach( $array as $value) {
	        if (in_array($type, $value["types"])) {
	            if ($short_name)    
	                return $value["short_name"];
	            return $value["long_name"];
	        }
	    }
	}
}