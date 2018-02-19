<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 18.1.2018 г.
 * Time: 20:35 ч.
 */

namespace Controller;

use Core\View\ViewInterface;
use Model\BindingModels\UserRegisterBindingModel;
use Service\Dummy\DummyServiceInterface;
use Service\User\UserServiceInterface;

class UserController
{
    /**
     * @var ViewInterface
     */
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function register()
    {
        $this->view->render();
    }

    public function registerProcess(UserRegisterBindingModel $bindingModel, DummyServiceInterface $dummyService, UserServiceInterface $userService)
    {
        $userService->register($bindingModel);
        $dummyService->printSmth();

    }

}