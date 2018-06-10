<?php
/**
 * 演示使用依赖注入的例子,升华版
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
    public function set($k,$v)
    {
        echo 'redis set cache '.$k.'='.$v. ' ok!';
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
    public function __construct(cache $cache)
    {
        $this->_cache_obj = $cache;
    }

    public function set_cache($k,$v)
    {
        $this->_cache_obj->set($k,$v);
    }


}

//例子开始
$cache = new mongodb_cache();
//$cache = new redis_cache();
$user = new user($cache);
$user->set_cache('user','james');

