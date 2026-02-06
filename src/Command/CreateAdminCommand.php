<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Créer un utilisateur avec accès complet'
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Email
        $email = $io->ask('Email de l’utilisateur');

        if ($this->entityManager->getRepository(User::class)->findOneBy(['email' => $email])) {
            $io->error('❌ Cet email existe déjà');
            return Command::FAILURE;
        }

        // Mot de passe (caché)
        $plainPassword = $io->askHidden('Mot de passe');

        if (strlen($plainPassword) < 6) {
            $io->error('❌ Mot de passe trop court (min 6 caractères)');
            return Command::FAILURE;
        }

        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plainPassword
        );

        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('✅ Utilisateur créé avec succès');

        return Command::SUCCESS;
    }
}
