<?php

namespace App\Action;

use App\Entity\User;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class CreateUser
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EmailVerifier $emailVerifier,
    ) {}

    public function execute(array $data)
    {
        $user = new User();

        $plainPassword = $data['plainPassword'];

        $user->setPassword($this->userPasswordHasher->hashPassword($user, $plainPassword));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
        //     (new TemplatedEmail())
        //         ->from(new Address('mailer@helpdesk.com', 'HelpDesk'))
        //         ->to((string) $user->getEmail())
        //         ->subject('Please Confirm your Email')
        //         ->htmlTemplate('registration/confirmation_email.html.twig')
        // );
    }
}
