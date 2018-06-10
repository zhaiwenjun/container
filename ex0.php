<?php
/**
 * 演示传统使用例子
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/10 0010
 * Time: 下午 7:13
 */

class cache{

    protected $_cache_obj = null;
    public function __construct()
    {
        //初始化缓存对象redis缓存/文件缓存/mongodb缓存。
        //$this->_cache_obj = new Redis();
        //$this->_cache_obj->connect('127.0.0.1', 6379);

        //mongodb
        //$this->_cache_obj = new MongoDB\Driver\Manager("mongodb://localhost:27017");

        //memcache连接
        //$memcache=new Memcache;
        //连接memcache
        //$this->_cache_obj=$memcache->connect('127.0.0.1',11211);
    }

    /**
     * 设置缓存
     * @param $k
     * @param $v
     */
    public function set($k,$v)
    {
        ///todo 执行缓存操作。
        echo 'set cache '.$k.'='.$v. ' ok!';
    }
}



class user{

    private  $_cache_obj = null;
    public function __construct()
    {
        //$this->_cache_obj = new cache_file();
        $this->_cache_obj = new cache();

    }
    public function set_cache($k,$v)
    {
        $this->_cache_obj->set($k,$v);
    }

}

//例子开始
$user = new user();

$user->set_cache('username','netman');
