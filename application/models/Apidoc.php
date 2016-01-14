<?php
/**
 * @name ApidocModel
 * @author ruansheng
 */
class ApidocModel {

    private $masterApidocCollection = null;

    /**
     * __construct
     */
    public function __construct() {
        $this->masterApidocCollection = MongoClientFactory::getBlogMongoClient()->selectCollection('apidoc');
    }

    /**
     * 添加接口
     * @param $data
     * @return array
     */
    public function addApidoc($data) {
        $status = $this->masterApidocCollection->insert($data);
        if(!$status) {
            return array(false, '保存失败');
        }
        return array(true, '保存成功');
    }

    /**
     * 更新接口
     * @param $_id
     * @param $data
     * @return array
     */
    public function updateApidoc($_id, $data) {
        $query = array('_id'=>new MongoId($_id));
        $row = $this->masterApidocCollection->findOne($query);
        if($row) {
            $status = $this->masterApidocCollection->update($query, $data, array('upsert'=>false));
            if(!$status) {
                return array(false, '保存失败');
            }
            return array(true, '保存成功');
        } else {
            return array(false, '接口不存在');
        }
    }

    /**
     * 获取接口
     * @param $query
     * @param $fields
     * @param $sort
     * @return bool
     */
    public function getApidoc($query =[], $fields = [], $sort = ['time' => -1]) {
        $rows = $this->masterApidocCollection->find($query, $fields)->sort($sort);
        $list = [];
        foreach($rows as $item) {
            $list[] = $item;
        }
        return $list;
    }

    /**
     * 删除接口
     * @param $_id
     * @return bool
     */
    public function deleteApidoc($_id) {
        $query = array(
            '_id' => new MongoId($_id)
        );
        $status = $this->masterApidocCollection->remove($query);
        if(!$status) {
            return array(false, '删除失败');
        }
        return array(true, '删除成功');
    }
}
