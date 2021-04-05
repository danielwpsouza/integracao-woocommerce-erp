<?php

class autenticationERP {

	function aut($url){
		
		$store_url = $url;
		$endpoint = '/wc-auth/v2/authorize';
		$params = [
		    'app_name' => 'My App Name',
		    'scope' => 'write',
		    'user_id' => 123,
		    'return_url' => 'http://app.com',
		    'callback_url' => 'https://app.com'
		];
		$query_string = http_build_query($params);

		echo $store_url . $endpoint . '?' . $query_string;

	}

}