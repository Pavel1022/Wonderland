<?php

namespace WonderlandBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use WonderlandBundle\Entity\User;
use WonderlandBundle\Form\UserType;
use WonderlandBundle\Service\User\UserServiceInterface;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register/user", name="user_register_user")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        /**
         * @var UploadedFile $file
         */
        $file = $form['file']->getData();
        if($file)
        {
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('profileImage_directory'), $fileName
            );
            $register = $this->userService->registerUser($form, $user, $fileName);
        } else {
            $register = $this->userService->registerUser($form, $user);
        }

        if (gettype($register) === 'array')
        {
            $errors = $register;
            return $this->render("users/register.html.twig",
                ["form" => $form->createView(),
                    "errors" => $errors]
            );
        }
        if ($register === true)
        {
            return $this->redirectToRoute('security_login');
        }
        return $this->redirectToRoute('user_register');
    }

    /**
     * @Route("/user/register", name="user_register")
     * @return RedirectResponse|Response
     */
    public function viewRegisterAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        return $this->render("users/register.html.twig",
            ["form" => $form->createView(),
                "errors" => false]
        );
    }

    /**
     * @Route("/logout", name="security_logout")
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception("Logout failed!");
    }

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profileAction()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $currentUser = $this->userService->getUser($this->getUser());
        return $this->render("users/profile.html.twig",
            ['user' => $currentUser]);
    }
}
