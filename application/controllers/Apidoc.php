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

            $v['time'] = date('Y-m-d H:i:s', $v['time']);

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

        $is_full = true;

        $fields = array();
        foreach($data['field_types'] as $tk=>$tname) {
            foreach($data['field_names'] as $nk=>$nname) {
                foreach ($data['field_defaults'] as $dk => $dname) {
                    foreach ($data['field_descs'] as $ddk => $ddname) {
                        if($tk == $nk && $nk == $dk && $dk == $ddk) {
                            if(empty($tname) || empty($nname) || empty($ddname)) {
                                $is_full = false;
                            } else {
                                $fields[] = array(
                                    'type' => $tname,
                                    'name' => $nname,
                                    'default' => $dname,
                                    'desc' => $ddname
                                );
                            }
                        }
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
            'time' => time(),
            'update_time' => time()
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

        $is_full = true;

        $fields = array();
        foreach($data['field_types'] as $tk=>$tname) {
            foreach($data['field_names'] as $nk=>$nname) {
                foreach ($data['field_defaults'] as $dk => $dname) {
                    foreach ($data['field_descs'] as $ddk => $ddname) {
                        if($tk == $nk && $nk == $dk && $dk == $ddk) {
                            if(empty($tname) || empty($nname) || empty($ddname)) {
                                $is_full = false;
                            } else {
                                $fields[] = array(
                                    'type' => $tname,
                                    'name' => $nname,
                                    'default' => $dname,
                                    'desc' => $ddname
                                );
                            }
                        }
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
            'update_time' => time()
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

        if(!in_array($data['request_method'], ['GET', 'POST'])) {
            $this->responseJson(402, '接口的请求方式不正确');
        }

        // 构造请求参数
        $header = [];
        $body = [];
        $cookie = [];

        if(isset($data['request_params']) && !empty($data['request_params'])){
            foreach($data['request_params'] as $key => $val) {
                $key_row = explode('-', $key);
                $param_type = $key_row[0];  // 参数类型 header body cookie
                $param_name = $key_row[1];
                if($param_type == 'header') {
                    $header[] = $param_name . ':' . $val;
                } else if($param_type == 'body') {
                    $body[$param_name] = $val;
                } else if($param_type == 'cookie') {
                    $cookie[] = $param_name . ':' . $val;
                }
            }
        }

        $ret = [];

        $Curl = new Curl();
        if(!empty($header)) {
            $Curl = $Curl->header($header);
        }
        if(!empty($cookie)) {
            $Curl = $Curl->cookie(implode(';', $cookie));
        }
        if(!empty($body)) {
            $Curl = $Curl->body($body);
        }

        if($data['request_method'] == 'GET') {
            $ret = $Curl->get($data['request_api']);
        } else if($data['request_method'] == 'POST') {
            $ret = $Curl->post($data['request_api']);
        }

        $ret['header'] = $Curl->getResponseHeader();
        $ret['body'] = json_decode($Curl->getResponseBody(), true);

        $Curl->close();

        $this->responseJson(200, 'success', $ret);
        return false;
    }
}
