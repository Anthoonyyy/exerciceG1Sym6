# exerciceG1Sym6

- Créez un fork de ce projet
- Suivez les `README.md` de https://github.com/WebDevCF2m2023/EntitiesG1

A partir des `entités` et du `.env` de ce `repository`,

Créez la base de donnée, trouvez un template front et/ou un autre template back

Vouz devez pouvoir vous connecter avec un `User` (avec mot de passe crypté) au rôle `ROLE_ADMIN`

Créez une administration en back-end,

Mais surtout un site (+-) fonctionnel en front-end


## Les fixtures

Ce sont des des données générés pour remplir nos base de donnés en `dev`

Voir la documentation: 

https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html

## Installation

     composer require --dev orm-fixtures

Cette commande nous crée un fichier par défaut :
    
     src/DataFixtures/AppFixtures.php

On va commencer à insérer un `user`  
```php
<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
# on va récupérer notre entité user
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        # Instantiation d'un user
        $user = new User();
        $user->setUsername('admin');
        $user->setUserMail("admin@hotmail.com");
        $user->setRoles(['ROLE_ADMIN', 'ROLE_REDAC','ROLE_MODERATOR']);
        $user->setPassword('admin');
        $user->setUserActive(true);
        $user->setUserRealName('The Admin !');

        # Utilisation du $manager pour mettre le User en mémoire
         $manager->persist($user);

        # envoie à la base de donnée (commit)
        $manager->flush();
    }
}

```
Pour l'insérer dans la DB, on peut utiliser

    php bin/console doctrine:fixtures:load

ou

    php bin/console d:f:l

** Ceci écrase la DB ! **, Pour éviter, vous pouvez ajouter :

    php bin/console d:f:l --append

### Hachage des mots de passe

Ici notre mot de passe n'est pas crypté et seul notre admin est disponible
On va importer le hasher de mot de passe
```php
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
```

### On souhaite avoir ces utilisateurs

- admin -> admin -> [ ROLE_ADMIN, ROLE_REDAC, ROLE_MODERATOR ]
- redac1 -> redac1 -> [ROLE_REDAC]
- redac2 -> redac2 -> [ROLE_REDAC]
- redac3 -> redac3 -> [ROLE_REDAC]
- redac4 -> redac4 -> [ROLE_REDAC]
- redac5 -> redac5 -> [ROLE_REDAC]
- moderator -> moderator -> [ROLE_MODERATOR]
-
-