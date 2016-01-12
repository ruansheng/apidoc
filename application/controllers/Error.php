<?php
/**
 * @name ErrorController
 * @desc 错误控制器, 在发生未捕获的异常时刻被调用
 * @author ruansheng
 */
class ErrorController extends Yaf_Controller_Abstract {

    /**
     * 从2.1开始, errorAction支持直接通过参数获取异常
     * @param $exception
     */
	public function errorAction($exception) {
        header('Content-type:text/json;');
        $ret = array(
            'en' => 501,
            'em' => 'error',
            'data' =>array($exception->__toString())
        );
        // 保存错误提示
        //$exception->__toString();
        exit(json_encode($ret));
	}
}
