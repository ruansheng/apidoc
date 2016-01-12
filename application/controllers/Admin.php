<?php
/**
 * @name AdminController
 * @author ruansheng
 * @desc 管理员
 */
class AdminController extends Base {

    /**
     * 登录
     * http://demo.mpress_api.com/admin/index
     * @return bool
     */
    public function indexAction() {
        $this->getView()->assign('title', 'blog');
        return true;
    }

    /**
     * 登录
     * http://demo.mpress_api.com/admin/login
     * @return bool
     */
    public function loginAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['username'])) {
            header('Location:/admin/index');
            exit;
        } else if(empty($data['username'])){
            header('Location:/admin/index');
            exit;
        }

        if(!isset($data['password'])) {
            header('Location:/admin/index');
            exit;
        } else if(empty($data['password'])){
            header('Location:/admin/index');
            exit;
        }

        if($data['username'] == 'admin' && $data['password'] == 'admin') {
            $_SESSION['adminid'] = 'admin';
        } else {
            header('Location:/admin/index');
            exit;
        }

        header('Location:/index/index');
        exit;
        return false;
    }

    /**
     * 退出
     * http://demo.mpress_api.com/admin/logout
     * @return bool
     */
    public function logoutAction() {
        unset($_SESSION['adminid']);
        header('Location:/admin/index');
        exit;
        return false;
    }
}
