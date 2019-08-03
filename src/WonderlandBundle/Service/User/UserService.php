<?php


namespace WonderlandBundle\Service\User;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use WonderlandBundle\Entity\Role;
use WonderlandBundle\Entity\User;
use WonderlandBundle\Service\Validator\User\UserValidatorServiceInterface;

class UserService implements UserServiceInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $userRepository;

    /**
     * @var UserValidatorServiceInterface
     */
    private $userValidatorService;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    private $roleRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                UserValidatorServiceInterface $userValidatorService,
                                UserPasswordEncoderInterface $encoder)
    {
        $this->entityManager = $entityManager;
        $this->userValidatorService = $userValidatorService;
        $this->encoder = $encoder;
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->roleRepository = $entityManager->getRepository(Role::class);
    }


    public function registerUser($form, $user, $fileName = null)
    {
        $user->setFile($fileName);
        $this->userValidatorService->validate($user->getUsername(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPhone(),
            $user->getEmail(),
            $user->getFile(),
            $this->entityManager
                ->getRepository(User::class)
                ->findAll());
        $errors = $this->userValidatorService->getErrors();
        if($errors) {
            return $errors;
        }
        $password = $this->encoder
            ->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        $userRole = $this->roleRepository->findOneBy(['name' => 'ROLE_USER']);

        $user->addRole($userRole);

        $em = $this->entityManager;
        $em->persist($user);
        $em->flush();
        return true;
    }

    public function getUser($user)
    {
        return $this->userRepository->find($user);
    }
}