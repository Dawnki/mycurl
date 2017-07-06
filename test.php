<?php

require_once __DIR__.'/MyCurl.php';

  	$header = array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        'Connection: keep-alive',
        'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    );

   $data = array();

   $url = '';

   $method = '';    // POST or GET

   $obj = new MyCurl($url,$method);

   $obj->setHeader($header)
  	   ->setParam($data)
       ->setCookies($exist)
       ->exec();

   $error=$obj->getError();

   $result=$obj->getResponse();

   print_r($result);