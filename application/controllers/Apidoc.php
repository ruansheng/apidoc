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
            $v['_id'] = $v['_id']->{'$id'};
            $v['fields'] = json_encode($v['fields']);

            $v['time'] = date('Y-m-d H:i:s', $v['time']->sec);

            $list[] = $v;
        }
        $this->getView()->assign('list', $list);
        return true;
    }

    /**
     * 添加保存api
     * http://demo.mpress_api.com/apidoc/addApi
     * @return bool
     */
	public function addApiAction() {
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
            'time' => new MongoDate(),
            'update_time' => new MongoDate()
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

    /**
     * 编辑保存api
     * http://demo.mpress_api.com/apidoc/saveApi
     * @return bool
     */
    public function saveApiAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['_id'])) {
            $this->responseJson(401, '_id no isset');
        } else if(empty($data['_id'])){
            $this->responseJson(401, '_id is empty');
        }

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
            'update_time' => new MongoDate()
        );

        $Apidoc = new ApidocModel();
        $ret = $Apidoc->updateApidoc($data['_id'], $row);

        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(402, $ret[1]);
        }

        return false;
    }

    /**
     * 删除
     * http://demo.mpress_api.com/apidoc/delete
     * @return bool
     */
    public function deleteAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['_id'])) {
            $this->responseJson(401, '_id no isset');
        } else if(empty($data['_id'])){
            $this->responseJson(401, '_id is empty');
        }

        $Apidoc = new ApidocModel();
        $ret = $Apidoc->deleteApidoc($data['_id']);

        if($ret[0]) {
            $this->responseJson(200, $ret[1]);
        } else {
            $this->responseJson(402, $ret[1]);
        }

        return false;
    }

    /**
     * 调试请求
     * http://demo.mpress_api.com/apidoc/requestDebug
     */
    public function requestDebugAction() {
        $data = $this->getRequest()->getRequest();

        if(!isset($data['request_api'])) {
            $this->responseJson(401, 'request_api no isset');
        } else if(empty($data['request_api'])){
            $this->responseJson(401, 'request_api is empty');
        }

        if(!isset($data['request_method'])) {
            $this->responseJson(401, 'request_method no isset');
        } else if(empty($data['request_method'])){
            $this->responseJson(401, 'request_method is empty');
        }

        if(!isset($data['request_params'])) {
            $this->responseJson(401, 'request_params no isset');
        }
        if(!empty($data['request_params'])){
            foreach($data['request_params'] as $key => $val) {
                if(empty($val)) {
                    $this->responseJson(401, $key . ' is empty');
                }
            }
        }

        $ret = [];

        $Curl = new Curl();
        if($data['request_method'] == 'GET') {
            if(empty($data['request_params'])) {
                $request_api = $data['request_api'];
            } else {
                $request_api = $data['request_api'] . '?'. http_build_query($data['request_params']);
            }

            $ret = $Curl->get($request_api);
            $Curl->close();
        } else if($data['request_method'] == 'POST') {
            if(!empty($data['request_params'])) {
                ksort($data['request_params']);
                $params = json_encode($data['request_params']);
                $params = base64_encode($this->encrypt($params));
                $ret = $Curl->data(['data'=>$params])->post($data['request_api']);
            } else {
                $ret = $Curl->data([])->post($data['request_api']);
            }
            $Curl->close();
        } else {
            $this->responseJson(402, '接口的请求方式不正确');
        }

        $ret = json_decode($ret, true);

        if(!empty($ret) && !empty($ret['data'])) {
            $ret['data'] = $this->decrypt(base64_decode($ret['data']));
        }

        $this->responseJson(200, 'success', $ret);
        return false;
    }
}