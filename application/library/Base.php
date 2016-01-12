<?php
/**
 * @name BaseController
 * @author ruansheng
 * @desc 基础控制器
 */
class Base extends Yaf_Controller_Abstract {

    protected $userId = null;

    private $whiteUri = array(
        '/admin/index',
        '/admin/login',
    );

    public function init() {
        session_start();
        $requestUri = $_SERVER['REQUEST_URI'];
        if(!in_array($requestUri, $this->whiteUri)) {
            $adminid = $_SESSION['adminid'];
            if(empty($adminid)) {
                header('Location:/admin/index');
            }
        }
    }

    /**
     * 加密
     * @param $string
     * @return string
     */
    function encrypt($string) {
        $key = 'mpress secret key';
        $iv = 'sdasfvds$^%@(@sd%@$#*';
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);
        $encrypted = mcrypt_generic($cipher,$string);
        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
        return $encrypted;
    }

    /**
     * 解密
     * @param $string
     * @return string
     */
    function decrypt($string) {
        $key = 'mpress secret key';
        $iv = 'sdasfvds$^%@(@sd%@$#*';
        $cipher = mcrypt_module_open(MCRYPT_BLOWFISH,'','cbc','');
        mcrypt_generic_init($cipher, $key, $iv);  //
        $decrypted = mdecrypt_generic($cipher,$string);
        mcrypt_generic_deinit($cipher);
        mcrypt_module_close($cipher);
        return $decrypted;
    }

    /**
     * 返回json
     * @param int    $en
     * @param string $em
     * @param array  $data
     */
    public function responseJson($en = 200, $em = 'ok', $data = []) {
        header('Content-type:text/json;');
        $ret = array(
            'en' => $en,
            'em' => $em,
            'data' => base64_encode($this->encrypt(json_encode($data))),
            'debug' => $data
        );
        exit(json_encode($ret));
    }

    /**
     * 打印输出
     * @param      $var
     * @param bool $exit
     */
    public function dump($var,$exit = false){
        echo '<pre>';
            print_r($var);
        echo '</pre>';
        if($exit) {
            exit;
        }
    }
}
