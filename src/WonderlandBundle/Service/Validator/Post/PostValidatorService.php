<?php


namespace WonderlandBundle\Service\Validator\Post;


class PostValidatorService implements PostValidatorServiceInterface
{
    private $errors = [];

    public function validateAddPost($title, $description, $file)
    {
        $this->errors = [];
        $this->checkTitle($title);
        $this->checkDescription($description);
        $this->checkFile($file);
    }

    public function checkTitle($title)
    {
        if (strlen($title) === 0)
        {
            $this->errors[] = 'Title field is empty!';
            return true;
        }
        if (strlen($title) < 10)
        {
            $this->errors[] = 'Title must have minimum 10 symbols!';
            return true;
        }
    }

    public function checkDescription($description)
    {
        if (strlen($description) === 0)
        {
            $this->errors[] = 'Description field is empty!';
            return true;
        }
        if (strlen($description) < 40)
        {
            $this->errors[] = 'Description must have minimum 40 symbols!';
            return true;
        }
    }

    public function checkFile($file)
    {
        if (!$file)
        {
            $this->errors[] = 'Not uploaded file!';
            return true;
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validateEditPost($title, $description)
    {
        $this->errors = [];
        $this->checkTitle($title);
        $this->checkDescription($description);
    }
}