<?php
/**
 * @name TestController
 * @author ruansheng
 * @desc 管理员
 */
class TestController extends Yaf_Controller_Abstract {

    /**
     * 添加账号
     * http://demo.mpress_api.com/test/addAdmin
     * @return bool
     */
    public function addAdminAction() {
        $Admin = new AdminModel();
        $Admin->addAdmin('admin','admin');
        return false;
    }
}
