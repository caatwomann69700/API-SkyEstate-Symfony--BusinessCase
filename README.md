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



Explication des entity : 

+ ANNONCE 
Ce fichier représente une entité Annonce pour une application Symfony 6.4 exposée via une API grâce à API Platform. Voici les fonctionnalités principales :

Propriétés principales :

L'entité Annonce contient des propriétés comme title, description, price, surface, location, city, etc., pour décrire une annonce.
Relations avec d'autres entités :

Image : Une relation OneToOne pour associer une image principale.
Category : Une relation ManyToOne pour catégoriser les annonces.
Amenity : Une relation ManyToMany pour lister les équipements associés.
Reservation : Une relation OneToMany pour les réservations liées.
ImageList : Une relation OneToMany pour des images additionnelles.
Annotations de sérialisation :

Utilisation de Groups pour définir les contextes de lecture (annonces:read) et d'écriture (annonces:write) des données dans l'API.
Gestion des collections :

Les relations OneToMany et ManyToMany utilisent ArrayCollection pour gérer plusieurs objets (réservations, équipements, images).
Dates importantes :

createdAt et updatedAt permettent de gérer les métadonnées temporelles d'une annonce.
Automatisation :

L'identifiant est généré automatiquement (#[ORM\GeneratedValue]).
Les cascades (persist et remove) garantissent une gestion cohérente des relations lors de l'ajout ou de la suppression.
Interopérabilité API :

La classe est directement exposée comme une ressource API grâce à #[ApiResource].
Fonctions utilitaires :

Des méthodes comme addReservation, removeAmenity, ou addImageList facilitent la manipulation des collections dans le code métier.


+ AMENITY 

Annotations Doctrine :

Configuration des colonnes, clés primaires, relations avec d'autres entités (Annonce).
Déclaration des types de données (integer, string, text).
Annotations API Platform :

ApiResource : Expose l'entité comme une ressource API.
Groups : Définissent les contextes de sérialisation/désérialisation.
Relations :

Relation ManyToMany entre Amenity et Annonce pour indiquer qu'un équipement peut être associé à plusieurs annonces.
Constructeur et gestion des collections :

Le constructeur initialise les collections avec ArrayCollection.
Les méthodes addAnnonce et removeAnnonce assurent la gestion des relations entre Amenity et Annonce.
Getters et setters :

Fournissent des accès contrôlés pour chaque propriété (lecture/écriture).
Le code est bien structuré pour gérer les équipements (Amenity) et leurs associations avec des annonces (Annonce). Les groupes définissent clairement ce qui est accessible via l'API en lecture ou écriture.


+ CATEGORY 
Annotations ORM :

Définissent les relations et les propriétés des colonnes pour la base de données.
Indiquent les types de colonnes (string, text, etc.) et les relations (OneToOne, OneToMany).
Annotations API Platform :

Utilisées pour exposer l'entité comme une ressource API et configurer les groupes de lecture et d'écriture.
Relations :

Une catégorie peut être associée à plusieurs annonces (OneToMany).
Une catégorie peut avoir une image principale (OneToOne).
Getters et Setters :

Utilisés pour lire et modifier les propriétés de la catégorie.
Constructeur :

Initialise les propriétés de type collection (annonces) avec ArrayCollection.

+ IMAGE
Annotations ORM :

Définissent les colonnes et les relations dans la base de données.
Id et GeneratedValue spécifient que l'identifiant est unique et généré automatiquement.
Les relations OneToOne indiquent que cette image peut être associée à une annonce ou une catégorie.
Annotations API Platform :

ApiResource expose cette entité comme une ressource API.
Les groupes (images:read, etc.) définissent quels champs sont disponibles dans les requêtes API.
Relations :

Annonce : Une image peut être liée à une annonce via une relation OneToOne.
Category : Une image peut être liée à une catégorie via une relation OneToOne.
Getters et Setters :

Fournissent un moyen d'accéder aux propriétés (getId, getName, etc.).
Permettent de modifier les propriétés (setName, setAnnonce, etc.).
Le code est bien écrit et suit les conventions pour une entité Symfony, avec des relations et une exposition correcte via API Platform. 

+ IMAGE LIST 
Annotations ORM :

La clé primaire id est générée automatiquement.
La colonne name est une chaîne de caractères avec une limite de 255 caractères.
La relation ManyToOne avec l'entité Annonce permet de lier plusieurs images à une seule annonce.
Annotations pour API Platform :

Les groupes de sérialisation/désérialisation (annonces:read et annonces:write) rendent les champs accessibles lors de la lecture et de l'écriture via API.
Getters et Setters :

Les getters permettent d'accéder aux propriétés (id, name, annonce).
Les setters permettent de modifier les propriétés en les liant à une annonce ou en modifiant leur nom.
Le code est simple et efficace pour gérer une liste d'images associées à une annonce. Les annotations et méthodes sont bien organisées pour une utilisation fluide avec Doctrine et API Platform.

+ RESERVATION 

Annotations ORM :

Définissent les colonnes dans la base de données et les relations avec d'autres entités.
L'identifiant (id) est une clé primaire auto-générée.
Les colonnes startDate, endDate, status, totalAmount, etc., stockent les données principales de la réservation.
Annotations API Platform :

Expose l'entité comme une ressource API avec des groupes pour les opérations de lecture (reservation:read) et écriture (reservation:write).
Relations :

La relation ManyToOne avec l'entité Annonce indique qu'une réservation est liée à une seule annonce.
Getters et Setters :

Permettent d'accéder aux propriétés de l'entité (id, startDate, status, etc.) ou de les modifier.
Le code est bien structuré pour gérer les réservations et leurs relations avec les annonces, en respectant les conventions Symfony et Doctrine.