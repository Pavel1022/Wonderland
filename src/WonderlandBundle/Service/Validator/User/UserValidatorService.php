<?php


namespace WonderlandBundle\Service\Validator\User;


class UserValidatorService implements UserValidatorServiceInterface
{
    
    private $errors = [];
    
    public function checkUsername($username, $users)
    {
        if (strlen($username) === 0)
        {
            $this->errors[] = 'Username field is empty!';
            return true;
        }
        if (!(strlen($username) > 4 && strlen($username) < 15))
        {
            $this->errors[] = 'Username must be between 4 and 15 symbols!';
            return true;
        }
        foreach ($users as $user)
        {
            if ($username === $user->getUsername())
            {
                $this->errors[] = 'This username is already taken!';
                break;
            }
        }
    }

    public function checkPassword($password)
    {
        if (strlen($password) === 0)
        {
            $this->errors[] = 'Password field is empty!';
            return true;
        }
        if (strlen($password) < 8)
        {
            $this->errors[] = 'Password must have minimal 8 symbols!';
            return true;
        }
    }

    public function checkFirstName($firstName)
    {
        if (strlen($firstName) === 0)
        {
            $this->errors[] = 'First Name field is empty!';
            return true;
        }
        if (!(strlen($firstName) > 3 && strlen($firstName) < 15))
        {
            $this->errors[] = 'First Name must be between 3 and 15 symbols!';
            return true;
        }
    }

    public function checkLastName($lastName)
    {
        if (strlen($lastName) === 0)
        {
            $this->errors[] = 'First Name field is empty!';
            return true;
        }
        if (!(strlen($lastName) > 3 && strlen($lastName) < 15))
        {
            $this->errors[] = 'Last Name must be between 3 and 15 symbols!';
            return true;
        }
    }

    public function checkEmail($email)
    {
        if (strlen($email) === 0)
        {
            $this->errors[] = 'E-Mail field is empty!';
            return true;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid E-Mail format";
            return true;
        }
    }

    public function checkFile($file)
    {
        if (!$file)
        {
            $this->errors[] = 'Not uploaded file!';
        }
    }

    public function validate($username, $password, $firstName, $lastName, $phone, $email, $file, $users)
    {
        $this->checkUsername($username, $users);
        $this->checkPassword($password);
        $this->checkFirstName($firstName);
        $this->checkLastName($lastName);
        $this->checkPhone($phone);
        $this->checkEmail($email);
        $this->checkFile($file);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function checkPhone($phone)
    {
        if (strlen($phone) !== 10)
        {
            $this->errors[] = 'Phone number must be 10 digits!';
        }
    }

}