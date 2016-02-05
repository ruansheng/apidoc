<?php
/**
 * @name CurlLib
 * @author ruansheng
 * $curl=new Curl();
 * echo $curl->data(array('name'=>'ruansheng'))->post("http://www.qwbcg.com/");
 * echo $curl->close();
 */
class Curl {
    /**
     * 操作句柄
     * @var mixed
     */
    private $handler;

    /**
     * 默认HTTP设置
     * @var array
     */
    private $defaultOptions=array(
        //连接等待时间
        CURLOPT_CONNECTTIMEOUT => 30,
        //最长请求时间
        CURLOPT_TIMEOUT => 60,
        //文件流的形式返回
        CURLOPT_RETURNTRANSFER => 1,
        //每次都用新连接代替缓存中的连接
        CURLOPT_FRESH_CONNECT => true,
        //返回响应头
        CURLOPT_HEADER => true
    );

    /**
     * HHTPS 设置
     * @var mixed
     */
    private $httpsOptions = array(
        //不验证证书
        CURLOPT_SSL_VERIFYPEER => false,
        //不验证证书
        CURLOPT_SSL_VERIFYHOST => false
    );

    /**
     * 响应结果码
     * @var int
     */
    private $response_errno = 0;

    /**
     * 结果字符串信息
     * @var string
     */
    private $response_errmsg = '';

    /**
     * 请求头
     * @var string
     */
    private $request_header = [];

    /**
     * 请求体
     * @var string
     */
    private $request_body = [];

    /**
     * 响应体
     * @var string
     */
    private $response_body = [];

    /**
     * 请求cookie
     * @var string
     */
    private $request_cookie = '';

    /**
     * 响应头
     * @var string
     */
    private $response_header = '';

    /**
     * 构造函数
     */
    public function __construct(){
        $this->handler = curl_init();
        $this->init();
    }

    /**
     * 初始化 set HTTP选项
     */
    private function init(){
        curl_setopt_array($this->handler,$this->defaultOptions);
    }

    /**
     * set HTTPS选项
     * @return Curl
     */
    public function https(){
        curl_setopt_array($this->handler,$this->httpsOptions);
        return $this;
    }

    /**
     * 封装执行请求
     * @param $url
     * @return mixed
     */
    private function request($url){
        curl_setopt($this->handler,CURLOPT_URL,$url);
        $result = curl_exec($this->handler);
        $this->setResult($result);
        $this->setErr();
        return $result;
    }

    /**
     * 设置请求头
     * @param $data array('SESSION:xxxxx','TOKEN:xxxxx')
     * @return Curl
     */
    public function header($data = []){
        if($data) {
            curl_setopt($this->handler, CURLOPT_HTTPHEADER,$data); //设置头信息
            $this->request_header = $data;
        }
        return $this;
    }

    /**
     * 设置post参数
     * @param $data array('name'=>'rs','age'=>21)
     * @return Curl
     */
    public function body($data = []){
        $this->request_body = $data;
        return $this;
    }

    /**
     * 设置cookie
     * @param $data 'name=rs;age=21'
     * @return Curl
     */
    public function cookie($data){
        if($data) {
            curl_setopt($this->handler, CURLOPT_COOKIE, $data); //设置cookie信息
            $this->request_cookie = $data;
        }
        return $this;
    }

    /**
     * GET 请求
     * @param string $url
     * @return bool
     */
    public function get($url){
        if($this->request_body) {
           $url .= '?'. http_build_query($this->request_body);
        }
        $this->request($url);
        return true;
    }

    /**
     * POST 请求
     * @param $url
     * @return bool
     */
    public function post($url){
        curl_setopt($this->handler, CURLOPT_POST, 1);
        if($this->request_body) {
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $this->request_body);
        }
        $this->request($url);
        return true;
    }

    /**
     * 解析
     * @param $result
     */
    private function setResult($result) {
        $headerSize = curl_getinfo($this->handler, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $headerSize);
        $body =  substr($result, $headerSize);
        $this->response_header = $header;
        $this->response_body = $body;
    }

    /**
     * 设置 请求结果码
     */
    private function setErr(){
        if(curl_errno($this->handler)){
            $this->response_errno = curl_errno($this->handler);
            $this->response_errmsg = curl_error($this->handler);
        }
    }

    /**
     * 获取 请求结果码
     * @return mixed
     */
    public function getErrno(){
        return $this->response_errno;
    }

    /**
     * 获取 请求结果字符串信息
     * @return mixed
     */
    public function getErrmsg(){
        return $this->response_errmsg;
    }

    /**
     * 获取 请求头
     * @return mixed
     */
    public function getRequestHeader(){
        return $this->request_header;
    }

    /**
     * 获取 响应body
     * @return mixed
     */
    public function getResponseBody(){
        return $this->response_body;
    }

    /**
     * 获取 响应头
     * @return mixed
     */
    public function getResponseHeader(){
        return $this->response_header;
    }

    /**
     * 获取 请求设置的cookie
     * @return mixed
     */
    public function getCookie(){
        return $this->request_cookie;
    }

    /**
     * 关闭 curl句柄
     */
    public function close(){
        curl_close($this->handler);
    }
}
