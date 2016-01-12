<?php
/**
 * @name TestController
 * @author ruansheng
 * @desc 测试
 */
class TestController extends Base {

    /**
     * 测试
     * http://demo.apidoc.com/test/index
     * @return bool
     */
    public function indexAction() {
        $this->responseJson();
        return false;
    }

    /**
     * 测试
     * http://demo.apidoc.com/test/test
     * @return bool
     */
    public function testAction() {
        return true;
    }
}
