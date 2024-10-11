<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
# On va hacher les mots de passe
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
# on va récupérer notre entité User
use App\Entity\User;
# Chargement de Faker et création alias nommé faker
use Faker\Factory as Faker;

class AppFixtures extends Fixture
{
    # attribut contenant le hacher de mot de passe
    private UserPasswordHasherInterface $passwordHasher;

    # constructeur qui remplit les attributs
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        # hache le mot de passe
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        ###
        # Instanciation d'un User Admin
        #
        $user = new User();
        $user->setUsername('admin');
        $user->setUserMail('admin@gmail.com');
        $user->setRoles(['ROLE_ADMIN','ROLE_REDAC','ROLE_MODERATOR']);
        # hachage du mot de passe
        $pwdHash = $this->passwordHasher->hashPassword($user, 'admin');
        # insertion du mot de passe haché
        $user->setPassword($pwdHash);
        $user->setUserActive(true);
        $user->setUserRealName('The Admin !');

        # Utilisation du $manager pour mettre le
        # User en mémoire
        $manager->persist($user);

        ###
        # Instanciation de 5 Rédacteurs
        #
        for($i = 1; $i <= 5; $i++){
            $user = new User();
            $user->setUsername('redac'.$i);
            $user->setUserMail('redac'.$i.'@gmail.com');
            $user->setRoles(['ROLE_REDAC']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'redac'.$i);
            $user->setPassword($pwdHash);
            $user->setUserActive(true);
            $user->setUserRealName('The Redac '.$i.' !');
            # Utilisation du $manager pour mettre le
            # User en mémoire
            $manager->persist($user);
        }

        for($i = 1; $i <= 3; $i++){
            $user = new User();
            $user->setUsername('moderator'.$i);
            $user->setUserMail('moderator'.$i.'@gmail.com');
            $user->setRoles(['ROLE_MODERATOR']);
            $pwdHash = $this->passwordHasher->hashPassword($user, 'moderator'.$i);
            $user->setPassword($pwdHash);
            $user->setUserActive(true);
            $user->setUserRealName('The Moderator '.$i.' !');
            # Utilisation du $manager pour mettre le
            # User en mémoire
            $manager->persist($user);
        }
        # instantiation de faker en français
        $faker = Faker::create('fr_FR');

        # Instanciation entre 20 et 40 users sans rôles
        $hasard = mt_rand(20,40);
        for($i = 1; $i <= $hasard; $i++){
            $user = new User();
            # nom d'utilisateur au hasard commençant par user-1234
            $username = $faker->numerify('user-####');
            $user->setUsername($username);
            # création d'un mail au hasard
            $mail = $faker->email();
            $user->setUserMail($mail);
            $user->setRoles(['ROLE_USER']);
            # transformation du nom en mit de passe (pour les tests)
            $pwdHash = $this->passwordHasher->hashPassword($user, $username);
            $user->setPassword($pwdHash);
            # on va activer 1 user sur 3
            $randActive = mt_rand(0,2);
            $user->setUserActive($randActive);
            # création d'un 'vrai' nom en fr
            $realName = $faker->name();
            $user->setUserRealName($realName);

            $manager->persist($user);
        }


        # envoie à la base de donnée (commit)
        $manager->flush();
    }
}