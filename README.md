# Blog

### **Installation**

1. Cloner le projet
2. Modifier le .env.local
    - DATABASE_URL=mysql://`username`:`password`@localhost:3306/`database`?serverVersion=10.7
        - username: le nom d'utilisateur
        - password : le mot de  passe
        - database = nom de la base de données
3. Installer les dépendances de PHP : `composer install`
4. Installer les dépendances du client : `npm install && npm run dev`
5. Lancer les migrations : `php bin/console doctrine:migrations:migrate`
6. Visiter le site web : `http://localhost:8000`

