<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 17:48 ч.
 */

namespace Core\View;


class View implements ViewInterface
{
    private $className;
    private $methodName;


    public function __construct($className, $methodName)
    {
        $this->className = $className;
        $this->methodName = $methodName;
    }


    function render($viewName = null, $data = null)
    {
        if ($viewName == null || is_object($viewName)) {
            $data = $viewName;
            $viewName = $this->className . DIRECTORY_SEPARATOR . $this->methodName;
        }
        require_once "View/" . $viewName . ".php";
    }
}