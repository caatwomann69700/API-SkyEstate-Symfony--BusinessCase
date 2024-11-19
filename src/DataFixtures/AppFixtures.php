<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Image;
use App\Entity\Category;
use App\Entity\Amenity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Base URL pour les images locales
        $baseUrl = 'http://localhost:8000/images/';

        // Création des catégories avec leurs images et descriptions
        $categoriesData = [
            'maison' => [
                'name' => 'Maison',
                'image' => $baseUrl . 'category1.jpg',
                'description' => 'Si vous avez besoin de plus d’espace, réservez un logement entier rien que pour vous'
            ],
            'appartement' => [
                'name' => 'Appartement',
                'image' => $baseUrl . 'category2.jpg',
                'description' => 'Réservez des logements pratiques dans des immeubles partagés'
            ],
            'studio' => [
                'name' => 'Studio',
                'image' => $baseUrl . 'category3.jpg',
                'description' => 'Profitez de votre chambre privée et partagez les espaces communs avec d\'autres'
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $key => $data) {
            // Créer une instance Category
            $category = new Category();
            $category->setName($data['name'])
                     ->setDescription($data['description']);

            // Créer une instance Image pour la catégorie
            $image = new Image();
            $image->setName($data['image']);

            // Associer l'image à la catégorie
            $category->setImage($image);

            // Persister l'image et la catégorie
            $manager->persist($image);
            $manager->persist($category);

            // Sauvegarder la catégorie pour l'utiliser dans les annonces
            $categories[$key] = $category;
        }

        // Création des amenities globales
        $amenitiesData = [
            'Vue sur le jardin',
            'Cuisine',
            'Wifi',
            'Parking gratuit sur place',
            'Télévision',
            'Station de recharge pour véhicules électriques',
            'Lave-linge (Gratuit) dans le bâtiment',
            'Sèche-linge (Gratuit) dans le bâtiment',
            'Privé : patio ou balcon',
            'Climatisation',
            'Chauffage',
            'Bureau',
            'Cheminée',
            'Piscine',
            'Jacuzzi',
            'Salle de sport',
            'Lit bébé',
            'Barbecue',
            'Espace de travail dédié',
            'Alarme incendie'
        ];

        $amenities = [];
        foreach ($amenitiesData as $name) {
            $amenity = new Amenity();
            $amenity->setName($name)
                    ->setDescription("Description de l'amenity $name");

            $manager->persist($amenity);
            $amenities[$name] = $amenity; // Associer par nom pour des relations fixes
        }

        // Données d'exemple pour les annonces et leurs images
        $annoncesData = [
            
                [
                    'title' => 'Superbe appartement au centre-ville',
                    'description' => 'Un bel appartement lumineux et spacieux, idéalement situé au centre-ville.',
                    'price' => '1200.00',
                    'surface' => '80m²',
                    'city' => 'Paris',
                    'postal_code' => '75001',
                    'location' => '12 rue de Rivoli, Paris',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'imageslyn.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Parking gratuit sur place',
                        'Télévision',
                        'Climatisation',
                        'Bureau'
                    ]
                ],
                [
                    'title' => 'Charmante maison avec jardin paisible',
                    'description' => 'Une magnifique maison offrant calme et sérénité, avec un jardin privé. Parfait pour se détendre loin de l’agitation urbaine.',
                    'price' => '1800.00',
                    'surface' => '120m²',
                    'city' => 'Lyon',
                    'postal_code' => '69005',
                    'location' => '8 chemin du Vallon, Lyon',
                    'maxOccupants' => '6',
                    'image' => $baseUrl . 'house_lyon.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Piscine',
                        'Barbecue',
                        'Climatisation',
                        'Chauffage',
                        'Lave-linge (Gratuit) dans le bâtiment'
                    ]
                ],
                [
                    'title' => 'Maison de campagne avec jardin',
                    'description' => 'Charmante maison en pleine nature avec un grand jardin.',
                    'price' => '950.00',
                    'surface' => '120m²',
                    'city' => 'Bordeaux',
                    'postal_code' => '33000',
                    'location' => '15 route des Vignes, Bordeaux',
                    'maxOccupants' => '6',
                    'image' => $baseUrl . '123.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Piscine',
                        'Lave-linge (Gratuit) dans le bâtiment',
                        'Sèche-linge (Gratuit) dans le bâtiment',
                        'Cheminée'
                    ]
                ],
                [
                    'title' => 'Studio moderne et bien situé',
                    'description' => 'Studio parfait pour étudiant ou jeune professionnel, proche de toutes commodités.',
                    'price' => '600.00',
                    'surface' => '30m²',
                    'city' => 'Lyon',
                    'postal_code' => '69002',
                    'location' => '25 place Bellecour, Lyon',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'imagemarsseil.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Chauffage',
                        'Privé : patio ou balcon',
                        'Espace de travail dédié',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Appartement familial avec terrasse',
                    'description' => 'Appartement spacieux avec grande terrasse, idéal pour famille.',
                    'price' => '1500.00',
                    'surface' => '100m²',
                    'city' => 'Marseille',
                    'postal_code' => '13006',
                    'location' => '10 avenue du Prado, Marseille',
                    'maxOccupants' => '5',
                    'image' => $baseUrl . 'imageparis (1).jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Cuisine',
                        'Climatisation',
                        'Lit bébé',
                        'Piscine',
                        'Télévision',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Loft en centre historique',
                    'description' => 'Magnifique loft avec vue imprenable sur le centre historique.',
                    'price' => '2000.00',
                    'surface' => '150m²',
                    'city' => 'Nice',
                    'postal_code' => '06000',
                    'location' => '5 promenade des Anglais, Nice',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'imagesbordeaux.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Salle de sport',
                        'Jacuzzi',
                        'Climatisation',
                        'Espace de travail dédié',
                        'Télévision'
                    ]
                ],
                [
                    'title' => 'Maison avec vue sur la rivière',
                    'description' => 'Belle maison familiale avec jardin donnant sur la rivière.',
                    'price' => '1250.00',
                    'surface' => '95m²',
                    'city' => 'Rouen',
                    'postal_code' => '76000',
                    'location' => '20 rue Saint-Sever, Rouen',
                    'maxOccupants' => '5',
                    'image' => $baseUrl . 'imagerouen.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Piscine',
                        'Climatisation',
                        'Cheminée',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Studio en plein cœur du quartier latin',
                    'description' => 'Studio confortable idéal pour étudiant, proche des universités.',
                    'price' => '700.00',
                    'surface' => '22m²',
                    'city' => 'Paris',
                    'postal_code' => '75005',
                    'location' => '7 rue Soufflot, Paris',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'imageparis_studio.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Télévision',
                        'Alarme incendie',
                        'Chauffage',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Appartement moderne avec balcon',
                    'description' => 'Appartement récent avec toutes commodités et un grand balcon.',
                    'price' => '1100.00',
                    'surface' => '70m²',
                    'city' => 'Lille',
                    'postal_code' => '59000',
                    'location' => '15 rue Nationale, Lille',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'imagelille.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Parking gratuit sur place',
                        'Climatisation',
                        'Télévision',
                        'Lit bébé'
                    ]
                ],
                [
                    'title' => 'Maison proche des commodités',
                    'description' => 'Maison confortable à proximité des écoles et commerces.',
                    'price' => '1000.00',
                    'surface' => '85m²',
                    'city' => 'Dijon',
                    'postal_code' => '21000',
                    'location' => '3 boulevard Carnot, Dijon',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'imagedijon.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Cheminée',
                        'Piscine',
                        'Télévision',
                        'Lave-linge (Gratuit) dans le bâtiment'
                    ]
                ],
                [
                    'title' => 'Studio rénové avec kitchenette',
                    'description' => 'Studio refait à neuf, idéal pour une première city.',
                    'price' => '550.00',
                    'surface' => '28m²',
                    'city' => 'Reims',
                    'postal_code' => '51100',
                    'location' => '8 rue Chanzy, Reims',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'imagereims.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Cuisine',
                        'Chauffage',
                        'Climatisation',
                        'Privé : patio ou balcon',
                        'Alarme incendie',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Appartement proche du parc',
                    'description' => 'Appartement lumineux à deux pas du parc municipal.',
                    'price' => '900.00',
                    'surface' => '60m²',
                    'city' => 'Orléans',
                    'postal_code' => '45000',
                    'location' => '18 rue Jeanne d\'Arc, Orléans',
                    'maxOccupants' => '2',
                    'image' => $baseUrl . 'imageorleans.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Parking gratuit sur place',
                        'Télévision',
                        'Espace de travail dédié',
                        'Piscine'
                    ]
                ],
            
            ];
   
            // Ajoutez d'autres annonces ici avec leurs amenities

        // Création des annonces avec les images, catégories et amenities
        foreach ($annoncesData as $data) {
            $annonce = new Annonce();
            $annonce->setTitle($data['title'])
                    ->setDescription($data['description'])
                    ->setPrice($data['price'])
                    ->setSurface($data['surface'])
                    ->setcity($data['city'])
                    ->setLocation($data['location'])
                    ->setPostalCode($data['location'])
                    ->setMaxOccupants($data['maxOccupants'])
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable());

            // Créer une image pour l'annonce
            $image = new Image();
            $image->setName($data['image']);
            $annonce->setImage($image); // Associe l'image à l'annonce

            // Associer la catégorie à l'annonce
            $annonce->setCategory($categories[$data['category']]);

            // Associer les amenities définies dans $data['amenities']
            foreach ($data['amenities'] as $amenityName) {
                $annonce->addAmenity($amenities[$amenityName]);
            }

            // Persister l'image et l'annonce
            $manager->persist($image);
            $manager->persist($annonce);
        }

        // Enregistrement en base de données
        $manager->flush();
    }
}
