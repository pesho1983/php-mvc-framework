<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 19:54 ч.
 */

namespace Model\BindingModels;


class UserRegisterBindingModel
{
    private $username;
    private $password;
    private $confirmPassword;

    /**
     * @return mixed
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param mixed $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


}