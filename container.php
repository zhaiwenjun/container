<?php
/**
 * 简单服务容器类
 * Created by PhpStorm.
 * User: Netman
 * Date: 2018/6/10 0010
 * Time: 下午 7:10
 */

class Container
{
    //绑定的对象
    protected $binds;

    //
    protected $instances;

    //绑定服务
    public function bind($abstract, $concrete)
    {
        // 如果是匿名函数（Anonymous functions），也叫闭包函数（closures）
        if ($concrete instanceof Closure)
        {
            $this->binds[$abstract] = $concrete;
        }
        else
        {
            $this->instances[$abstract] = $concrete;
        }
    }

    //生产服务
    public function make($abstract, $parameters = array())
    {
        if (isset($this->instances[$abstract]))
        {
            return $this->instances[$abstract];
        }

        array_unshift($parameters, $this);

        return call_user_func_array($this->binds[$abstract], $parameters);
    }
}