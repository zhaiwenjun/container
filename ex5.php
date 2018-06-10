<?php
include "container.php";
/**
 * 演示使用简单版容器
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/10 0010
 * Time: 下午 7:13
 */

//缓存组件通用接口
interface cache {
    public function get($key, $lifetime);
    public function set($key, $value);
    public function delete($key);
}


class mongodb_cache implements cache {
    /**
     * 设置缓存
     * @param $k
     * @param $v
     */
    public function set($k,$v)
    {
        echo 'mongodb set cache '.$k.'='.$v. ' ok!';
    }
   public function get($key, $lifetime)
   {
       // TODO: mongodb Implement get() method.
   }

    public function delete($key)
    {
        // TODO: mongodb Implement delete() method.
    }
}

class redis_cache implements cache {
    private $_obj = null;
    public function __construct(cache $obj = null)
    {
        if($obj)
        {
            $this->_obj = $obj;
        }

    }

    public function set($k,$v)
    {
        if($this->_obj)
        {
            $this->_obj->set($k,$v);
        }
        else
        {
            echo 'redis set cache '.$k.'='.$v. ' ok!';
        }

    }
    public function get($key, $lifetime)
    {
        // TODO: mongodb Implement get() method.
    }
    public function delete($key)
    {
        // TODO: redis Implement delete() method.
    }

}

class user{

    private  $_cache_obj = null;
    //注意这里传入的对象前面的声明。
    public function __construct(cache $cache_obj)
    {
        $this->_cache_obj = $cache_obj;
    }
    public function set_cache($k,$v)

    {
        $this->_cache_obj->set($k,$v);
    }


}

//例子开始
$container = new Container();
$container->bind('redis', function($container) {
    return new redis_cache();
});
$container->bind('mongodb', function(){
    return new mongodb_cache();
});

//使用redis 缓存
$cache = $container->make('redis');
$user = new user($cache);
$user->set_cache('user','james');


