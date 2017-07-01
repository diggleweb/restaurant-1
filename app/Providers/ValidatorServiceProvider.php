<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use InvalidArgumentException;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('isImageListUpload', function($attribute,$values, $parameters)
        {
            if( empty($values) 
                || count($values) <1 
                || empty($values[0])){
                return true;
            }
            if (!is_array($values)) {
                throw new InvalidArgumentException('Attribute for each() must be an array.');
            }
            foreach ($values as $key => $value) {
                try{
                    if (!$value instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                        throw new InvalidArgumentException('Attribute list must be an instance of Symfony\Component\HttpFoundation\File\UploadedFile.');
                    }
                    $tmp_arr = explode('.', $value->getClientOriginalExtension());
                    $ext = end($tmp_arr);
                    if(!in_array($ext, array('jpeg','jpg', 'png', 'gif', 'bmp', 'svg'))){
                        return false;
                    };
                }
                catch(\Exception $e){
                    return false;
                }
            }

            return true;
        });
    }

    public function register()
    {
        //
    }
}