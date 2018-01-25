<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 15:56 ч.
 */

namespace Core;


use Core\ModelBinding\ModelBinderInterface;
use Core\View\View;

class Application
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var string
     */
    private $methodName;
    /**
     * @var []
     */
    private $params;
    private $modelBinder;

    /**
     * Application constructor.
     * @param string $className
     * @param string $methodName
     * @param string[] $params
     * @param ModelBinderInterface $modelBinder
     */
    public function __construct(string $className, string $methodName, array $params, ModelBinderInterface $modelBinder)
    {
        $this->className = ucfirst($className);
        $this->methodName = $methodName;
        $this->params = $params;
        $this->modelBinder = $modelBinder;
    }

    public function start()
    {
        $controllerName = "Controller\\" . ucfirst($this->className) . "Controller";
        $view = new View($this->className, $this->methodName);

        $controller = new $controllerName($view);
        $actionInfo = new \ReflectionMethod($controllerName, $this->methodName);

        $pos = -1;
        $internalPos = 0;
        $allParameters = [];
        foreach ($actionInfo->getParameters() as $parameter) {
            $pos++;
            $class = $parameter->getClass();
            if (null === $class) {
                $allParameters[$pos] = $this->params[$internalPos];
                $internalPos++;
                continue;
            }

            $class = $class->getName();
            $bindingModel = $this->modelBinder->bind($_POST, $class);

            $allParameters[$pos] = $bindingModel;

        }
        //приема клас, метод и параметри
        call_user_func_array(
            [
                $controller,
                $this->methodName
            ],
            $allParameters);
    }

}