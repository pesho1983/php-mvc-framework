<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 15:56 ч.
 */

namespace Core;

use Core\DependencyManagement\ContainerInterface;
use Core\Http\RequestInterface;
use Core\ModelBinding\ModelBinderInterface;

class Application implements ApplicationInterface
{
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ModelBinderInterface
     */
    private $modelBinder;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Application constructor.
     * @param RequestInterface $request
     * @param ModelBinderInterface $modelBinder
     * @param ContainerInterface $container
     */
    public function __construct(RequestInterface $request, ModelBinderInterface $modelBinder, ContainerInterface $container)
    {
        $this->request = $request;
        $this->modelBinder = $modelBinder;
        $this->container = $container;
    }


    public function start()
    {
        $controllerName = "Controller\\" . ucfirst($this->request->getClassName()) . "Controller";

        $controller = $this->container->resolve($controllerName);

        $actionInfo = new \ReflectionMethod($controllerName, $this->request->getMethodName());

        $pos = -1;
        $internalPos = 0;
        $allParameters = [];
        $requestParams = $this->request->getParams();
        foreach ($actionInfo->getParameters() as $parameter) {
            $pos++;
            $class = $parameter->getClass();
            if (null === $class) {
                $allParameters[$pos] = $requestParams[$internalPos];
                $internalPos++;
                continue;
            }

            $class = $class->getName();
            $parameter = null;
            if ($this->container->exists($class)) {
                $parameter = $this->container->resolve($class);
            } else {
                $parameter = $this->modelBinder->bind($_POST, $class);
            }
            $allParameters[$pos] = $parameter;

        }
        //приема клас, метод и параметри
        call_user_func_array(
            [
                $controller,
                $this->request->getMethodName()
            ],
            $allParameters);
    }


}