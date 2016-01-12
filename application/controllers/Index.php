<?php
/**
 * @name IndexController
 * @author ruansheng
 * @desc 首页
 */
class IndexController extends Base {

    /**
     * 工具-首页
     * http://demo.mpress_api.com/index/index
     * @return bool
     */
    public function indexAction() {
        return true;
    }

    /**
     * 实时抓包工具
     * http://demo.mpress_api.com/index/apidata
     * @return bool
     */
    public function apidataAction() {
        return true;
    }

}
