<?php


namespace WonderlandBundle\Service\User;


interface UserServiceInterface
{
    public function registerUser($form, $userEntity, $fileName = null);

    public function getUser($user);
}