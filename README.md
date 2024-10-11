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

On va commencer à insérer des `users`  