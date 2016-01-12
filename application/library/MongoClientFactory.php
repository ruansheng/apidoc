<?php
/**
 * @name MongoFactory
 * @author ruansheng
 */
class MongoClientFactory {

    /**
     * getBlogMongoClient
     * @return MongoDb
     */
    public static function getBlogMongoClient() {
        $db = 'apidoc';
        $MongoClient = self::getMongoClient(array('host'=>'127.0.0.1', 'port'=>27017), $db);
        return $MongoClient->selectDB($db);
    }

    /**
     * getBlogAuthMongoClient
     * @return MongoClient
     */
    public static function getBlogAuthMongoClient() {
        $user = '';
        $pwd = '';
        $db = 'apidoc';
        $MongoClient = self::getAuthMongoClient(array('host'=>'127.0.0.1', 'port'=>27017), array('user'=>$user,'pwd'=>$pwd), $db);
        return $MongoClient->selectDB($db);
    }

    /**
     * getMongoClient
     * @param array $config
     * @param string $db
     * @param array $options
     * @return MongoClient
     */
    private static function getMongoClient($config = array('host'=>'127.0.0.1','port'=>27017),$db = 'test', $options = array('timeout'=>3000,'socketTimeoutMS'=>3000)){
        $server = sprintf('mongodb://'.$config['host'].':'.$config['port']);
        $options['db'] = $db;
        $MongoClient=new MongoClient($server, $options);
        return $MongoClient;
    }

    /**
     * getAuthMongoClient
     * @param array $config
     * @param array $auth
     * @param string $db
     * @param array $options
     * @return MongoClient
     */
    private static function getAuthMongoClient($config = array('host'=>'127.0.0.1','port'=>27017),$auth = array('user'=>'','pwd'=>''),$db = 'test', $options = array('timeout'=>3000,'socketTimeoutMS'=>3000)){
        $server = sprintf('mongodb://%s:%s@%s:%s',$auth['user'], $auth['pwd'], $config['host'], $config['port']);
        $options['db'] = $db;
        $MongoClient=new MongoClient($server, $options);
        return $MongoClient;
    }
}
