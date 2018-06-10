<?php
/**
 * 演示不使用依赖注入的例子
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/10 0010
 * Time: 下午 7:13
 */

class cache_mongodb{

    private $_cache_obj = null;

    public function __construct()
    {
        //mongodb
        //$this->_cache_obj = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    }

    /**
     * 设置文件缓存
     * @param $k
     * @param $v
     */
    public function set_cache($k,$v)
    {
        echo 'cache_file set cache '.$k.'='.$v. ' ok!';
    }
}

class cache_redis{

    public function __construct()
    {
        ///实例化redis 类

        //$this->_cache_obj = new Redis();
        //$this->_cache_obj->connect('127.0.0.1', 6379);
    }

    public function set_cache($k,$v)
    {
        echo 'cache_redis set cache '.$k.'='.$v. ' ok!';
    }

}

class user{

    private  $_cache_obj = null;
    public function __construct()
    {
        //$this->_cache_obj = new cache_mongodb();
        $this->_cache_obj = new cache_redis();

    }
    public function set_cache($k,$v)
    {
        $this->_cache_obj->set_cache($k,$v);
    }

}

//例子开始
$user = new user();

$user->set_cache('is_vip',1);
