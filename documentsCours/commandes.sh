symfony new {projectName} --webapp # Créé un projet symfony
symfony server:start # Démarre le serveur
symfony server:stop # Stop les serveurs

symfony console make:entity # Créé une entité
symfony console make:entity --regenerate # Complète les infos manquantes d'une entité
symfony console make:controller # Créé un controller
symfony console make:migration # Génère une migration

symfony console doctrine:database:create # Créé une BDD
symfony console doctrine:database:drop --force # Supprime une BDD
symfony console doctrine:migrations:migrate # Exécute les requêtes SQL des fichiers de migration
symfony console doctrine:fixtures:load # Exécute les fichiers de fixtures