<?php
/**
 * Created by PhpStorm.
 * User: Petar Aleksandrov
 * Date: 24.1.2018 г.
 * Time: 17:48 ч.
 */

namespace Core\View;


interface ViewInterface
{
    public function render($vewName = null, $data = null);
}