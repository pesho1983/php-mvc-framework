<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 17:48 ч.
 */

namespace Core\View;


use Core\Http\RequestInterface;

class View implements ViewInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }


    function render($viewName = null, $data = null)
    {
        if ($viewName == null || is_object($viewName)) {
            $data = $viewName;
            $viewName = $this->request->getClassName() . DIRECTORY_SEPARATOR . $this->request->getMethodName();
        }
        require_once "View/" . $viewName . ".php";
    }
}