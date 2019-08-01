<?php


namespace WonderlandBundle\Service\Validator;


interface UserValidatorServiceInterface
{
    public function __construct($username, $password, $firstName, $lastName, $phone, $email, $file, $users);

    public function checkUsername($username, $users);

    public function checkPassword($password);

    public function checkFirstName($firstName);

    public function checkLastName($lastName);

    public function checkPhone($phone);

    public function checkEmail($email);

    public function checkFile($file);

    public function getErrors();
}