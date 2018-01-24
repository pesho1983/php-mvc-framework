<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 15:56 ч.
 */

namespace Core;


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
     * @var string[]
     */
    private $params;

    /**
     * Application constructor.
     * @param string $className
     * @param string $methodName
     * @param string[] $params
     */
    public function __construct(string $className, string $methodName, array $params)
    {
        $this->className = ucfirst($className);
        $this->methodName = $methodName;
        $this->params = $params;
    }

    public function start()
    {
        $controllerName = "Controller\\" . ucfirst($this->className) . "Controller";
        $view = new View($this->className, $this->methodName);

        $controller = new $controllerName($view);
        $actionInfo = new \ReflectionMethod($controller, $this->methodName);
        echo "<pre>";
        var_dump($actionInfo->getParameters());

        $pos = -1;
        foreach ($actionInfo->getParameters() as $parameter) {
            $pos++;
            $class = $parameter->getClass();
            if (null === $class) {
                continue;
            }

            $bindingModel = new $class();
            $bindingModelInfo = new \ReflectionClass($class);
            foreach ($bindingModelInfo->getProperties() as $property) {
                $fieldName = $property->getName();
                if (!array_key_exists($fieldName, $_POST)) {
                    continue;
                }
                $value = $_POST[$fieldName];
                $setter ="set".ucfirst($fieldName);

                $bindingModel->$setter($value);
            }

        }
        //приема клас, метод и параметри
        call_user_func_array(
            [
                $controller,
                $this->methodName
            ],
            $this->params);
    }

}