<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Config;
// use Debugbar;

abstract class AppAdminBaseController extends AppBaseController {
/*
	protected function setupLayout()
	{
		Debugbar::info($this->layout);
		Debugbar::info(Request::ajax());
	    if ( ! is_null($this->layout))
	    {
	        $layout = Request::ajax() ? 'layouts/ajax' : $this->layout;
	        $this->layout = View::make($layout);            
	    }
	}
*/
	protected function fileUpload($upload_dir_constant, $file_key = "images"){
		try{
			$up_dir = Config::get('constant.site.upload_dir.'.$upload_dir_constant);
			if (empty($up_dir)) {
				return false;
			}
	        $destinationPath = public_path().DIRECTORY_SEPARATOR.$up_dir;
            dd(Request::file($file_key));
	        $rand_image_name = time().str_random(10);
	        $tmp_arr = explode('.', Request::file($file_key)->getClientOriginalExtension());
	        $ext = end($tmp_arr);
	        unset($tmp_arr);
	        $rand_image_name .= ".".$ext;
		    Request::file($file_key)->move($destinationPath, $rand_image_name);
		    return $rand_image_name;
		}
		catch(\Exception $e){
			return false;
		}
	}
     protected function uploadFiles($upload_dir_constant,$fileList){
		try{
            $up_dir = Config::get('constant.site.upload_dir.'.$upload_dir_constant);
    		if (empty($up_dir)) {
    			return false;
    		}
            $destinationPath = public_path().DIRECTORY_SEPARATOR.$up_dir;
            $i = 0;
            foreach($fileList as $im){
                //dd($im);
                $media[$i]['path'] = time().str_random(10);
                $media[$i]['media_type'] = $im->getClientMimeType();
                $tmp_arr = explode('.', $im->getClientOriginalExtension());
    	        $ext = end($tmp_arr);
    	        unset($tmp_arr);
    	        $media[$i]['path'] .= ".".$ext;
                $im->move($destinationPath, $media[$i]['path']);
                $i++;
            }
            return $media;
		}
		catch(\Exception $e){
		  //dd($e);
			return false;
		}
     }

}
