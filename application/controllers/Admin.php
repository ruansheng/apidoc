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
            $this->responseJson(401, 'username is empty');
        } else if(empty($data['username'])){
            $this->responseJson(401, 'username is empty');
        }

        if(!isset($data['password'])) {
            $this->responseJson(401, 'password is empty');
        } else if(empty($data['password'])){
            $this->responseJson(401, 'password is empty');
        }

        $Admin = new AdminModel();
        $ret = $Admin->login($data['username'], $data['password']);

        if($ret[0]) {
            $_SESSION['adminid'] = $ret[2];
            $this->responseJson(200, '登录成功');
        } else {
            $this->responseJson(402, '登录失败');
        }
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

    /**
     * 设置
     * http://demo.mpress_api.com/admin/setting
     * @return bool
     */
    public function settingAction() {
        $adminid = $_SESSION['adminid'];

        $Admin = new AdminModel();
        $info = $Admin->getAdminInfo($adminid);

        $this->getView()->assign('adminid', $adminid);
        $this->getView()->assign('info', $info);
        return true;
    }

    /**
     * 保存设置
     * http://demo.mpress_api.com/admin/saveSetting
     */
    public function saveSettingAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['_id'])) {
            $this->responseJson(401, '_id is empty');
        } else if(empty($data['_id'])){
            $this->responseJson(401, '_id is empty');
        }

        if(!isset($data['username'])) {
            $this->responseJson(401, 'username is empty');
        } else if(empty($data['username'])){
            $this->responseJson(401, 'username is empty');
        }

        if(!isset($data['password'])) {
            $this->responseJson(401, 'password is empty');
        } else if(empty($data['password'])){
            $this->responseJson(401, 'password is empty');
        }

        if(!isset($data['repassword'])) {
            $this->responseJson(401, 'repassword is empty');
        } else if(empty($data['repassword'])){
            $this->responseJson(401, 'repassword is empty');
        }

        if($data['password'] != $data['repassword']) {
            $this->responseJson(401, '密码与重复密码必须相等');
        }

        $Admin = new AdminModel();
        $ret = $Admin->saveSetting($data['_id'], $data['username'], $data['password']);

        if($ret[0]) {
            $this->responseJson(200, '登录成功');
        } else {
            $this->responseJson(402, '登录失败');
        }
        return false;
    }

    /**
     * 管理中心
     * http://demo.mpress_api.com/admin/manage
     * @return bool
     */
    public function manageAction() {
        $Admin = new AdminModel();
        $rows = $Admin->getAdminList();
        $list = [];
        foreach($rows as $v) {
            $v['_id'] = $v['_id']->{'$id'};
            $list[] = $v;
        }

        $this->getView()->assign('list', $list);
        return true;
    }

    /**
     * 添加保存管理员
     * http://demo.mpress_api.com/admin/addSaveAdmin
     * @return bool
     */
    public function addSaveAdminAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['username'])) {
            $this->responseJson(401, 'username is empty');
        } else if(empty($data['username'])){
            $this->responseJson(401, 'username is empty');
        }

        if(!isset($data['password'])) {
            $this->responseJson(401, 'password is empty');
        } else if(empty($data['password'])){
            $this->responseJson(401, 'password is empty');
        }

        if(!isset($data['repassword'])) {
            $this->responseJson(401, 'repassword is empty');
        } else if(empty($data['repassword'])){
            $this->responseJson(401, 'repassword is empty');
        }

        if($data['password'] != $data['repassword']) {
            $this->responseJson(401, '密码与重复密码必须相等');
        }

        if(!isset($data['status'])) {
            $this->responseJson(401, 'status is empty');
        }

        if(!isset($data['authority_read'])) {
            $this->responseJson(401, 'authority_read is empty');
        }

        if(!isset($data['authority_write'])) {
            $this->responseJson(401, 'authority_write is empty');
        }

        $Admin = new AdminModel();
        $Admin->addSaveAdmin($data['username'], $data['password'], $data['status'], $data['authority_read'], $data['authority_write']);
        $this->responseJson(200, '添加成功');
        return false;
    }

    /**
     * 删除管理员
     * http://demo.mpress_api.com/admin/deleteAdmin
     * @return bool
     */
    public function deleteAdminAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['_id'])) {
            $this->responseJson(401, '_id no isset');
        } else if(empty($data['_id'])){
            $this->responseJson(401, '_id is empty');
        }

        $Admin = new AdminModel();
        $ret = $Admin->deleteAdmin($data['_id']);

        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(402, $ret[1]);
        }

        return false;
    }
}
