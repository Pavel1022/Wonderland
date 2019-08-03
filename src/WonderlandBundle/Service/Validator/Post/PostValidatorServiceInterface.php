<?php


namespace WonderlandBundle\Service\Validator\Post;


interface PostValidatorServiceInterface
{
    public function validateAddPost($title, $description, $file);

    public function validateEditPost($title, $description);

    public function checkTitle($title);

    public function checkDescription($description);

    public function checkFile($file);

    public function getErrors();
}