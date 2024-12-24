
Guide du Projet : Authentification Sécurisée



TP du groupe composé de :

ADANHOUNDJI Eliel Fresnel M.
AHOUANGASSI Elie
LOPO Paula



🚀 Prérequis


Pour Windows :

    1. Installez XAMPP (inclut PHP, SQLite et Apache)
        ◦ Téléchargez XAMPP depuis le site officiel 
        ◦ Choisissez la version avec PHP 8.1 ou supérieur 
        ◦ Pendant l'installation, sélectionnez au minimum (Apache, Nginx), PHP et SQLite. Les systèmes linux viennent avec un serveur web. 
    2. Installez Composer
        ◦ Téléchargez l'installateur Windows sur getcomposer.org 
        ◦ Exécutez l'installateur (Composer-Setup.exe) 
        ◦ Assurez-vous de sélectionner votre PHP lors de l'installation (généralement dans C:\xampp\php\php.exe) 
    3. Vérifiez vos installations dans le terminal (CMD ou PowerShell) :
php -v
composer -v

Pour Linux/MacOS :
    • PHP 8.2 ou supérieur : php -v 
    • Composer : composer -v 
    • Sql ou phpmyadmin 



📥 Installation

Windows :
    • Clonez ou téléchargez le projet
    • Option 1 : Téléchargez le ZIP et extrayez-le dans C:\xampp\htdocs\tdd-php 
    • Option 2 : Utilisez Git Bash : 
cd C:\xampp\htdocs
git clone https://github.com/elielfresnel/TDD-EXAM.git
    2. Ouvrez le terminal (CMD) en tant qu'administrateur :
cd C:\xampp\htdocs\tdd-php
composer install
composer dump-autoload -o
    3. Modifier le fichier config,php qui se trouve dans le répertoire src du projet : 
    4. Créer une base de données register et importer la table register.sql 
    5. Importer la base de données database.SQL


Linux/MacOS :
git clone https://github.com/elielfresnel/TDD-EXAM.git
cd TDD-EXAM
composer install
cd src
nano src/config.php (vous modifiez en fonction des infos de votre base de données)



🚦 Lancer les tests

Windows :
cd C:\xampp\htdocs\tdd-php
.\vendor\bin\phpunit
Pour un test spécifique :
.\vendor\bin\phpunit Tests\AllTest.php
.\vendor\bin\phpunit Tests\SecurityTests.php

Linux/MacOS :
./vendor/bin/phpunit Tests\SecurityTests.php
.\vendor\bin\phpunit Tests\AllTest.php



📝 Structure du Projet
TDD-PHP/
├── composer.json
├── composer.lock  
├── database.SQL  #base de données           
├── README.md 
├── register.sql {#table de base de données
├── register.txt  
└── Tests/
    └── SecurityTests.php
    └── AllTests.php 	
└── src/
    └── action.php 	
    └── home.php
    └── index.php 
    └── config.php
    └── logout.php
    └── profile-card.css 
    └── signin_action.php
    └── signin.php
    └── style.css





    	
🌐 Lancement du Projet
Avec XAMPP (Windows) :
    1. Démarrez XAMPP Control Panel 
    2. Activez Apache 
    3. Ouvrez votre navigateur et accédez à : 
http://localhost/TDD-EXAM
Avec le serveur PHP intégré :
# Windows (CMD)
cd C:\xampp\htdocs\tdd-php
php -S localhost:8000

# Linux/MacOS
php -S localhost:8000







📚 Documentation Utile
    • XAMPP Documentation 
    • PHPUnit Documentation 
    • Composer Windows Documentation 





📫 Support
En cas de problème : 
    1. Ecrivez à Eliel Fresnel au +229 90330808
    2. Créez une issue sur GitHub avec une capture d'écran des erreurs svp 





     Projet réalisé dans le cadre dun contrôle terminal en groupes de 3 pour le cours de TDD (Test Driven Developpement)

