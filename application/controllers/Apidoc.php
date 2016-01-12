<?php
/**
 * @name ApidocController
 * @author ruansheng
 * @desc Apidoc
 */
class ApidocController extends Base {

    /**
     * Api文档工具
     * http://demo.mpress_api.com/apidoc/index
     * @return bool
     */
    public function indexAction() {
        $Apidoc = new ApidocModel();
        $rows = $Apidoc->getApidoc();

        $list = [];
        foreach($rows as $v) {
            $v['fields'] = json_encode($v['fields']);
            $v['time'] = date('Y-m-d H:i:s', $v['time']->sec);
            $list[] = $v;
        }

        $this->getView()->assign('list', $list);
        return true;
    }

    /**
     * 添加保存api
     * http://demo.mpress_api.com/apidoc/saveApi
     * @return bool
     */
	public function saveApiAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['api_name'])) {
            $this->responseJson(401, 'api_name no isset');
        } else if(empty($data['api_name'])){
            $this->responseJson(401, 'api_name is empty');
        }

        if(!isset($data['api_url'])) {
            $this->responseJson(401, 'api_url no isset');
        } else if(empty($data['api_url'])){
            $this->responseJson(401, 'api_url is empty');
        }

        if(!isset($data['api_method'])) {
            $this->responseJson(401, 'api_method no isset');
        } else if(empty($data['api_method'])){
            $this->responseJson(401, 'api_method is empty');
        }

        if(!isset($data['field_names'])) {
            $this->responseJson(401, 'field_names no isset');
        } else if(empty($data['field_names'])){
            $this->responseJson(401, 'field_names is empty');
        }

        if(!isset($data['field_descs'])) {
            $this->responseJson(401, 'field_descs no isset');
        } else if(empty($data['field_descs'])){
            $this->responseJson(401, 'field_descs is empty');
        }

        $is_full = true;

        $fields = array();
        foreach($data['field_names'] as $nk=>$name) {
            foreach($data['field_descs'] as $dk=>$desc) {
                if($nk == $dk) {
                    if(empty($name) || empty($desc)) {
                        $is_full = false;
                    } else {
                        $fields[] = array(
                            'name' => $name,
                            'desc' => $desc
                        );
                    }
                }
            }
        }

        if(!$is_full) {
            $this->responseJson(401, '请求参数填写不完整');
        }

        // 组合结构
        $row = array(
            'api_name' => $data['api_name'],
            'api_url' => $data['api_url'],
            'api_method' => $data['api_method'],
            'fields' => $fields,
            'time' => new MongoDate()
        );

        $Apidoc = new ApidocModel();
        $ret = $Apidoc->addApidoc($row);

        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(402, $ret[1]);
        }

        return false;
	}
}
