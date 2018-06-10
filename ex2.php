<?php
/**
 * 演示使用依赖注入的例子
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/10 0010
 * Time: 下午 7:13
 */

class cache_mongodb{
    /**
     * 设置缓存
     * @param $k
     * @param $v
     */
    public function set_cache($k,$v)
    {
        echo 'cache_mongodb set cache '.$k.'='.$v. ' ok!';
    }
}

class cache_redis{
    public function set_cache($k,$v)
    {
        echo 'cache_redis set cache '.$k.'='.$v. ' ok!';
    }

}

class user{

    private  $_cache_obj = null;
    public function __construct($cache)
    {
        $this->_cache_obj = $cache;
    }
    public function set_cache($k,$v)
    {
        $this->_cache_obj->set_cache($k,$v);
    }

}

//例子开始
$cache_obj = new cache_redis();
//$cache_obj = new cache_file();
$user = new user($cache_obj);

$user->set_cache('is_vip',1);
