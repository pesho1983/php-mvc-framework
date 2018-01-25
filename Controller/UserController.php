<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 18.1.2018 г.
 * Time: 20:35 ч.
 */

namespace Controller;

use Core\View\View;
use Core\View\ViewInterface;
use Model\BindingModels\UserRegisterBindingModel;
use Model\UserDTO;
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

    public function registerProcess(UserRegisterBindingModel $bindingModel,UserServiceInterface $userService)
    {
                $userService->register($bindingModel);
                exit;
    }

    public function delete($name)
    {
        $user = new UserDTO();
        $user->setName($name);
        $this->view->render($user);
    }


    //moi gluposti
    public function sum(int $a, int $b, int $c)
    {
        $user = new UserDTO();
        $data = $a + $b + $c;
        $user->setId($data);
        $this->view->render($user);
    }
}