# The Cohort-Project "API Restfull" Symfony CLI

## Table des matières
1. [Introduction](https://github.com/caatwomann69700/Brace-Armchair-API---Symfony-Project/tree/main?tab=readme-ov-file#introduction)
2. [Fonctionnalités](https://github.com/caatwomann69700/Brace-Armchair-API---Symfony-Project/tree/main?tab=readme-ov-file#introduction)
3. [Recapulatif Des choses a faire](https://github.com/caatwomann69700/Brace-Armchair-API---Symfony-Project/tree/main?tab=readme-ov-file#introduction)
4. [Installation](https://github.com/caatwomann69700/Brace-Armchair-API---Symfony-Project/tree/main?tab=readme-ov-file#introduction)
5. [Création des entity](https://github.com/caatwomann69700/Brace-Armchair-API---Symfony-Project/tree/main?tab=readme-ov-file#introduction)
## Introduction
Colivio_API est une application back-end que j'ai développée avec le framework Symfony en vesrion 6.4 sans l'utilisation du webapp.
permettant de gérer des logements,annonces, utilisateurs, catégories,
Je l'ai conçue pour être utilisée comme API RESTful pour ensuite l'integrer dans une application angular coté front-end.
Au sein de cette API, j'ai utiliser API Platform pour la création et la gestion des points de terminaison API, avec une sécurisation via JWT.
## Fonctionnalités
## Installation
### Prérequis
+ PHP 8.1 ou plus 
+ Composer 
+ MySQL ou tout autre SGBD compatible 
+ Symfony CLI 
+ OpenSSL pour la gestion des certificats JWT 
## les Étapes d'installations 
1. Creation du projet avec la commande suivante 
```php
symfony new colivio_API --version=6.4 
```
2. Création d'un fichier .env.local a partir du .env et configuration des informations de la base de donnéess 
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/cOolivio_Api"
```
3. Creation de la base de données dans le terminal a la racine du projet avec la commande suivante : 
```
php bin/console doctrine:database:create
```
4. Installation de Composer avec la commande suivante : 
```
composer require orm 
```
5.  Installation du Profiler avec la commande suivante :
```
composer require --dev profiler
````
6. Installation du Maker avec la commande suivante :
```
composer require --dev maker
````
7. Installation des Fixtures avec la commande suivante :
```
composer require --dev orm-fixtures
````
7. Installation du Bundles de security avec la commande suivante :
```
composer require security
````
## Création de l'entity User differemment 
Pour commencer j'ai creer le " User " avec la commande suivante : 
```
php bin/console make: User
```
## Création des entities suivantes : 
+ User
+ Annoncement 
+ Housing  
+ Category 
+ Image
+ ImageList 
+ Comment
+ Message 
+ Reservation 
+ Amenity 


avec la commande suivante : 
```
php bin/console make:entity 
```
##  générer les entities dans notre base de données avec la commande suivante : 
```
php bin/console make:migration 
```
## exécuter nos entities avec la commande suivante : 
```
php bin/console doctrine:migrations:migrate
```
