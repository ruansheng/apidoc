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
     * @return bool
     */
    public function addApidoc($data) {
        $status = $this->masterApidocCollection->insert($data);
        if(!$status) {
            return array(false, '保存失败');
        }
        return array(true, '保存成功');
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

}
