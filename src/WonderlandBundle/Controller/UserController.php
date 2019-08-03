<?php

namespace WonderlandBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
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
        if ($this->getUser() !== null)
        {
            return $this->redirectToRoute('homepage');
        }
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
        if ($this->getUser() !== null)
        {
            return $this->redirectToRoute('homepage');
        }
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

    /**
     * @Route("/user/edit/{id}", name="edit_user")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return Response
     */
    public function viewEditAction($id)
    {
        $currentUser = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($currentUser->getId() !== $user->getId())
        {
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(UserType::class, $user);
        return $this->render("users/edit.html.twig",
            ["form" => $form->createView(),
                "user" => $user,
                "errors" => false]
        );
    }

    /**
     * @Route("/edit/user/{id}", name="edit_user_action")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $image = $user->getFile();
        $path = $this->getParameter('profileImage_directory').'/'.$image;
        $username = $user->getUsername();
        $password = $user->getPassword();
        $createdOn = $user->getCreatedOn();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        /**
         * @var UploadedFile $file
         */
        $file = $form['file']->getData();
        if ($file)
        {
            $fs = new Filesystem();
            $fs->remove([$path]);
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('profileImage_directory'), $fileName);
            $editAction = $this->userService->edit($user, $form, $fileName, $username, $password, $createdOn);
        }
        else {
            $editAction = $this->userService->edit($user, $form, $image, $username, $password, $createdOn);
        }
        if (gettype($editAction) === 'array')
        {
            $errors = $editAction;
            return $this->render("users/edit.html.twig",
                ["form" => $form->createView(),
                    "errors" => $errors,
                    "user" => $user]
            );
        }
        if ($editAction === true)
        {
            return $this->redirectToRoute('user_profile');
        }
        return $this->redirectToRoute('edit_user');

    }

    /**
     * @Route("/user/change/{id}", name="change_user")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param $id
     * @return Response
     */
    public function viewChangePassword($id)
    {
        $currentUser = $this->getUser();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($currentUser->getId() !== $user->getId())
        {
            return $this->redirectToRoute('homepage');
        }
        $form = $this->createForm(UserType::class, $user);
        return $this->render("users/change.html.twig",
            ["form" => $form->createView(),
                "user" => $user,
                "errors" => false]
        );
    }

    /**
     * @Route("/change/user/{id}", name="change_user_action")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function changePassword(Request $request, $id)
    {
        $currentUser = $this->getUser();
        $username = $currentUser->getUsername();
        $firstName = $currentUser->getFirstName();
        $lastName = $currentUser->getLastName();
        $phone = $currentUser->getPhone();
        $email = $currentUser->getemail();
        $createdOn = $currentUser->getCreatedOn();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getFirstName());
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPhone($phone);
        $user->setEmail($email);
        $user->setCreatedOn($createdOn);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('user_profile');
    }
}
