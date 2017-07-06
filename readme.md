# 封装CURL

  自己封装的CURL类，运用了链式操作，提升一下可读性

## 起步

  引入MyCurl类

```php
required_once __DIR__.'/MyCurl.php';
```

  创建MyCurl实例

```php
  $url = 'www.xxx.com';
  $method = 'POST'; 
  $obj = new MyCurl($url,$method); //$url 请求的url $method 请求方法,目前仅支持GET和POST
```

  链式操作

```php
  $data= [
        'key' => 'value'
  ];

  $obj->setHeader($header)     //设置请求的header
      ->setParam($data)        //设置请求参数(数组) 
      ->setCookies($cookiePath) //设置请求时附带cookie(需要文件路径)
      ->setSaveCookies($path,$filename) //设置响应后返回的cookies path存放的路径  $filename 存放的文件名
      ->setHttps() //https时需要设置
      ->exec();    //执行curl

  echo $obj->getResponse();  //返回结果
  echo $obj->getError();     //返回的错误
```

  链式操作中，按需调用。

  例子可以参照test.php

## todo
  * 补充其他HTTP方法