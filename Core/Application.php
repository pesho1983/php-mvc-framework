<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 15:56 ч.
 */

namespace Core;


use Core\Http\RequestInterface;
use Core\ModelBinding\ModelBinderInterface;
use Core\View\View;

class Application
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
     * Application constructor.
     * @param RequestInterface $request
     * @param ModelBinderInterface $modelBinder
     */
    public function __construct(RequestInterface $request, ModelBinderInterface $modelBinder)
    {
        $this->request = $request;
        $this->modelBinder = $modelBinder;
    }

    public function start()
    {
        $controllerName = "Controller\\" . ucfirst($this->request->getClassName()) . "Controller";
        $view = new View($this->request);

        $controller = new $controllerName($view);
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
            $bindingModel = $this->modelBinder->bind($_POST, $class);

            $allParameters[$pos] = $bindingModel;

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