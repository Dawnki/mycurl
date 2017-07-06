<?php

/**
 * Created by PhpStorm.
 * User: Dawnki
 * Date: 2017/7/6 0006
 */
class MyCurl
{
    /**
     *  curl连接句柄
     * @var resource
     */
    private $handle;

    /**
     *  HTTP请求方法
     * @var string
     */
    private $method;

    /**
     *  HTTP请求url
     * @var string
     */
    private $url;

    /**
     *  HTTP响应信息
     * @var string
     */
    private $response;

    /**
     *  请求错误信息
     * @var string
     */
    private $error;

    /**
     * MyCurl constructor.
     * @param $url string
     * @param $method string
     */
    public function __construct($url, $method = 'POST')
    {
        $this->handle = curl_init($url);
        $this->url = $url;
        $this->setMethod($method);
    }

    /**
     *  设置HTTP方法
     * @param $method string
     * @return $this
     */
    public function setMethod($method)
    {
        switch ($method) {
            case 'post':
            case 'POST':
                curl_setopt($this->handle, CURLOPT_POST, 1);
                $this->method = 'POST';
                break;
            case 'get':
            case 'GET':
                curl_setopt($this->handle, CURLOPT_POST, 0);
                $this->method = 'GET';
                break;
            default:
                $this->method = '';
                break;
        }
        return $this;
    }

    /**
     *  设置请求Header
     * @param $header array
     * @return $this
     */
    public function setHeader(Array $header)
    {
        curl_setopt($this->handle, CURLOPT_HTTPHEADER, $header);
        return $this;
    }

    /**
     *  设置发送请求时附带的cookies
     * @param $filePath string cookies文件路径
     * @return $this
     */
    public function setCookies($filePath)
    {
        if (file_exists($filePath)) {
            curl_setopt($this->handle, CURLOPT_COOKIEFILE, $filePath);
        }
        return $this;
    }

    /**
     *  若要接受返回的cookies则需要调用此方法
     * @param $path
     * @param $filename
     * @return $this
     */
    public function setSaveCookies($path, $filename)
    {
        if (is_dir($path)) {
            curl_setopt($this->handle, CURLOPT_COOKIEJAR, $path . '/' . $filename);
        }
        return $this;
    }

    /**
     *  设置发送参数
     * @param  $data array
     * @return $this
     */
    public function setParam(Array $data)
    {
        $query = http_build_query($data);
        switch ($this->method) {
            case 'GET':
                curl_setopt($this->handle, CURLOPT_URL, $this->url . '?' . $query);
                break;
            case 'POST':
                curl_setopt($this->handle, CURLOPT_POSTFIELDS, $query);
                break;
            default:
                break;
        }
        return $this;
    }

    /**
     *  若方式为https则需调用此方法
     * @return $this
     */
    public function setHttps()
    {
        curl_setopt($this->handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->handle, CURLOPT_SSL_VERIFYHOST, false);
        return $this;
    }

    /**
     *  执行请求
     * @return $this
     */
    public function exec()
    {
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 1);
        $this->response = curl_exec($this->handle);
        if ($this->response == false) {
            $this->error = curl_error($this->handle);
        }
        curl_close($this->handle);
        return $this;
    }

    /**
     *  获取响应结果
     * @return string
     */
    public function getResponse()
    {
        return isset($this->response) ? $this->response : '';
    }

    /**
     *  获取错误结果
     * @return string
     */
    public function getError()
    {
        return isset($this->error) ? $this->error : '';
    }

}