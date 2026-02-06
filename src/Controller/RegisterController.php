<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('password');
            $firstName = strtolower(trim($request->request->get('first_name')));
            $lastName  = strtolower(trim($request->request->get('last_name')));

            $username = $lastName . '.' . $firstName;


            if (!$email || !$plainPassword) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
            } else {
                // Vérifier si l’email existe déjà
                $existingUser = $entityManager
                    ->getRepository(User::class)
                    ->findOneBy(['email' => $email]);

                if ($existingUser) {
                    $this->addFlash('error', 'Cet email existe déjà.');
                } else {
                    $user = new User();
                    $user->setEmail($email);
                    $user->setRoles(['ROLE_USER']);

                    $hashedPassword = $passwordHasher->hashPassword(
                        $user,
                        $plainPassword
                    );
                    $user->setPassword($hashedPassword);
                    $user->setFirstName($firstName);
                    $user->setLastName($lastName);
                    $user->setUsername($username);


                    $entityManager->persist($user);
                    $entityManager->flush();

                    $this->addFlash('success', 'Compte créé avec succès, vous pouvez vous connecter.');
                    return $this->redirectToRoute('app_login');
                }
            }
        }

        return $this->render('security/register.html.twig');
    }
}
