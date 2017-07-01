<?php
/*
And you can access them as follows

Config::get('constants.langs');
// or if you want a specific one
Config::get('constants.langs.en');

And you can set them as well

Config::set('foo.bar', 'test');

*/
return [
    'site' => [
        'name' => 'Delivery on Wheel',
    	'logo' => 'images/site-logo.png',
        'upload_dir' => [
        	'store' => '/upload/store/',
        	'store_category' => '/upload/store_caterory/',
        	'product' => '/upload/product/',
            'promotion' => '/upload/promotion/'
    	],
        // etc
    ]
];