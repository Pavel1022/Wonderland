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
use WonderlandBundle\Service\Validator\UserValidatorService;

class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $form['file']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('profileImage_directory'), $fileName
            );
            $user->setFile($fileName);
            $validator = new UserValidatorService($user->getUsername(),
                $user->getPassword(),
                $user->getFirstName(),
                $user->getLastName(),
                $user->getPhone(),
                $user->getEmail(),
                $user->getFile(),
                $this->getDoctrine()
                    ->getRepository(User::class)
                    ->findAll());
            $errors = $validator->getErrors();
            if($errors) {
                return $this->render("users/register.html.twig",
                    ["form" => $form->createView(),
                        "errors" => $errors]
                );
            }
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('security_login');
        }
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
        $userRepository = $this->getDoctrine()
            ->getRepository(User::class);

        $currentUser = $userRepository->find($this->getUser());
        return $this->render("users/profile.html.twig",
            ['user' => $currentUser]);
    }
}
