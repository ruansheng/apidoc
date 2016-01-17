<?php
/**
 * @name AdminModel
 * @author ruansheng
 */
class AdminModel {

    private $masterAdminCollection = null;

    public function __construct() {
        $this->masterAdminCollection = MongoClientFactory::getApidocMongoClient()->selectCollection('admin');
    }

    /**
     * 登录检测
     * @param $username
     * @param $password
     * @return bool
     */
    public function login($username, $password) {
        $query = array(
            'username' => $username,
            'password' => sha1($password),
        );
        $row = $this->masterAdminCollection->findOne($query);
        if(empty($row)) {
            return array(false, '账号或密码错误');
        }
        return array(true, '登录成功', $row['_id']->{'$id'});
    }

    /**
     * 获取adminlist
     * @return array
     */
    public function getAdminList() {
        $rows = $this->masterAdminCollection->find();
        $list = [];
        foreach($rows as $row) {
            $list[] = $row;
        }
        return $list;
    }

    /**
     * 获取admininfo
     * @param $_id
     * @return array
     */
    public function getAdminInfo($_id) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $info = $this->masterAdminCollection->findOne($query);
        return $info;
    }

    /**
     * 保存设置
     * @param $_id
     * @param $username
     * @param $password
     * @return array
     */
    public function saveSetting($_id, $username, $password) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $info = $this->masterAdminCollection->findOne($query);
        if(empty($info)) {
            return array(false,'该账号不存在');
        }

        $data = array(
            'username' => $username,
            'password' => sha1($password),
            'update_time' => new MongoDate()
        );
        $this->masterAdminCollection->update($query, array('$set'=>$data), array('upsert'=>false));
        return array(true, '保存成功');
    }

    /**
     * 添加管理员
     * @param $username
     * @param $password
     * @param $status
     * @param $authority_read
     * @param $authority_write
     * @return array
     */
    public function addSaveAdmin($username, $password, $status, $authority_read, $authority_write) {
        $query = array(
            'username' => $username
        );
        $row = $this->masterAdminCollection->findOne($query);
        if($row) {
            return array(false, '要添加的账号已存在');
        }
        $data = array(
            'username' => $username,
            'password' => sha1($password),
            'super' => '0',
            'status' => strval($status),
            'time' => strval(time()),
            'update_time' => strval(time()),
            'authority'=>[],
        );
        if($authority_read) {
            $data['authority'][] = 'read';
        }
        if($authority_write) {
            $data['authority'][] = 'write';
        }

        $status = $this->masterAdminCollection->insert($data);
        if(!$status) {
            return array(false, '添加失败');
        }
        return array(true, '添加成功');
    }

    /**
     * 删除管理员
     * @param $_id
     * @return bool
     */
    public function deleteAdmin($_id) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $status = $this->masterAdminCollection->remove($query);
        if(!$status) {
            return array(false, '删除失败');
        }
        return array(true, '删除成功');
    }

}
