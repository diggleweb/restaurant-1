<?php

namespace App\Libraries\Repositories;


use App\Models\Media;
use Illuminate\Support\Facades\Schema;
use Config;
use InvalidArgumentException;

class MediaRepository
{
	/**
	 * Returns all Media
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function all()
	{
		return Media::all();
	}

	public function search($input)
    {
        $query = Media::query();

        $columns = Schema::getColumnListing('media');
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
	 * Stores Media into database
	 *
	 * @param array $input
	 *
	 * @return Media
	 */
	public function store($input)
	{
		return Media::insert($input);
	}

	/**
	 * Find Media by given id
	 *
	 * @param int $id
	 *
	 * @return \Illuminate\Support\Collection|null|static|Media
	 */
	public function findMediaById($id)
	{
		return Media::find($id);
	}

	/**
	 * Updates Media into database
	 *
	 * @param Media $media
	 * @param array $input
	 *
	 * @return Media
	 */
	public function update($media, $input)
	{
		$media->fill($input);
		$media->save();

		return $media;
	}

	/**
	 * Stores Media into database from files
	 *
	 * @param array $reference_id
	 * @param array $reference_type
	 * @param array $fileList
	 *
	 * @return true on success
	 */
     public function uploadFiles($reference_id, $reference_type, $fileList){
 		if (empty($reference_id)) {
			throw new InvalidArgumentException("Invalid reference id");
		}
		if (!in_array($reference_type, Media::$reference_types)) {
			throw new InvalidArgumentException("Invalid reference type");
		}
		if (!is_array($fileList)) {
			throw new InvalidArgumentException('param fileList must be an array.');
		}
        $destinationPath = public_path().Config::get('constant.site.upload_dir.'.strtolower($reference_type));

        $i = 0;
        foreach($fileList as $im){
        	if(empty($im)){continue;}
            if (!$im instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
				throw new InvalidArgumentException('Attribute list must be an instance of Symfony\Component\HttpFoundation\File\UploadedFile.');
			}
            $media[$i]['reference_id'] = $reference_id;
            $media[$i]['reference_type'] = $reference_type;
            $media[$i]['created_at'] = date('Y-m-d H:i:s');
            $media[$i]['updated_at'] = date('Y-m-d H:i:s');

            $media[$i]['path'] = time().str_random(10);
            $media[$i]['media_type'] = $im->getClientMimeType();
            $tmp_arr = explode('.', $im->getClientOriginalExtension());
	        $ext = end($tmp_arr);
	        unset($tmp_arr);
	        $media[$i]['path'] .= ".".$ext;
            $im->move($destinationPath, $media[$i]['path']);
            $i++;
        }
        if (!empty($media)) {
        	return Media::insert($media);
        }
        return false;
     }
}