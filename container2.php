<?php
/**
 * 自动解析依赖的服务容器类
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
            if(is_callable($this->instances[$abstract]))
            {
                return $this->instances[$abstract];
            }
            else
            {
                $className = $abstract;
                /** @var ReflectionClass $reflector */
                $reflector = new ReflectionClass($className);

                // 检查类是否可实例化, 排除抽象类abstract和对象接口interface
                if (!$reflector->isInstantiable())
                {
                    throw new Exception("Can't instantiate this.");
                }

                /** @var ReflectionMethod $constructor 获取类的构造函数 */
                $constructor = $reflector->getConstructor();

                // 若无构造函数，直接实例化并返回
                if (is_null($constructor))
                {
                    return new $className;
                }

                // 取构造函数参数,通过 ReflectionParameter 数组返回参数列表
                $parameters = $constructor->getParameters();

                // 递归解析构造函数的参数
                $dependencies = $this->get_dependencies($parameters);

                // 创建一个类的新实例，给出的参数将传递到类的构造函数。
                return $reflector->newInstanceArgs($dependencies);
            }

        }

        array_unshift($parameters, $this);

        return call_user_func_array($this->binds[$abstract], $parameters);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws Exception
     */
    public function get_dependencies($parameters)
    {
        $dependencies = array();

        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $parameter)
        {
            /** @var ReflectionClass $dependency */
            $dependency = $parameter->getClass();

            if (is_null($dependency))
            {
                // 是变量,有默认值则设置默认值
                $dependencies[] = $this->resolve_non_class($parameter);
            }
            else
            {
                // 是一个类，递归解析
                $dependencies[] = $this->make($dependency->name);
            }
        }

        return $dependencies;
    }

    /**
     * @param ReflectionParameter $parameter
     * @return mixed
     * @throws Exception
     */
    public function resolve_non_class($parameter)
    {
        // 有默认值则返回默认值
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }

        throw new Exception('I have no idea what to do here.');
    }
}