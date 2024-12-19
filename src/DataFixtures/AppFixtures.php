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

   // Base URL pour les icônes des amenities
  
   $iconBaseUrl = 'http://localhost:8000/icons/';
   // Création des amenities globales avec leurs icônes
   $amenitiesData = [
       ['name' => 'Vue sur le jardin', 'icon' => 'garden.png'],
       ['name' => 'Cuisine', 'icon' => 'kitchen.png'],
       ['name' => 'Wifi', 'icon' => 'wifi.png'],
       ['name' => 'Parking gratuit sur place', 'icon' => 'parking.png'],
       ['name' => 'Télévision', 'icon' => 'tv.png'],
       ['name' => 'Station de recharge pour véhicules électriques', 'icon' => 'chargingstation.png'],
       ['name' => 'Lave-linge (Gratuit) dans le bâtiment', 'icon' => 'lavelinge.png'],
       ['name' => 'Sèche-linge (Gratuit) dans le bâtiment', 'icon' => 'drycleaning.png'],
       ['name' => 'Privé : patio ou balcon', 'icon' => 'patio.png'],
       ['name' => 'Climatisation', 'icon' => 'airconditionner.png'],
       ['name' => 'Chauffage', 'icon' => 'heating.png'],
       ['name' => 'Bureau', 'icon' => 'desk.png'],
       ['name' => 'Cheminée', 'icon' => 'fireplace.png'],
       ['name' => 'Piscine', 'icon' => 'pool.png'],
       ['name' => 'Jacuzzi', 'icon' => 'jaccuzi.png'],
       ['name' => 'Salle de sport', 'icon' => 'gym.png'],
       ['name' => 'Lit bébé', 'icon' => 'baby-bed.png'],
       ['name' => 'Barbecue', 'icon' => 'barbecue.png'],
       ['name' => 'Espace de travail dédié', 'icon' => 'workspace.png'],
       ['name' => 'Alarme incendie', 'icon' => 'firealarm.png'],
   ];

   $amenities = [];
   foreach ($amenitiesData as $data) {
       // Génération du chemin complet de l'icône
       $iconUrl = $iconBaseUrl . $data['icon'];

       // Création de l'entité Image
       $icon = new Image();
       $icon->setName($iconUrl); // Définir l'URL HTTP complète de l'image
       $manager->persist($icon);

       // Création de l'entité Amenity
       $amenity = new Amenity();
       $amenity->setName($data['name'])
               ->setIcon($icon); // Associer l'image à l'amenity

       $manager->persist($amenity);

       // Sauvegarde dans le tableau pour des relations fixes si nécessaire
       $amenities[$data['name']] = $amenity;
   }

 

        // Données d'exemple pour les annonces et leurs images
        $annoncesData = [
            [
                'title' => 'Studio cosy en centre-ville',
                'description' => 'Un charmant studio équipé, parfait pour un étudiant ou un jeune actif.',
                'price' => '450.00',
                'surface' => '25m²',
                'city' => 'Montpellier',
                'postalcode' => '34000',
                'location' => '12 avenue du Jeu de Paume',
                'maxOccupants' => '1',
                'image' => $baseUrl . 'Studiocosy.jpg',
                'category' => 'studio',
                'amenities' => ['Wifi', 'Cuisine', 'Chauffage', 'Télévision', 'Espace de travail dédié', 'Alarme incendie']
            ],
            [
                'title' => 'Appartement fonctionnel proche des transports',
                'description' => 'Appartement idéalement situé avec un accès facile aux transports en commun.',
                'price' => '500.00',
                'surface' => '40m²',
                'city' => 'Toulouse',
                'postalcode' => '31000',
                'location' => '18 boulevard Carnot',
                'maxOccupants' => '2',
                'image' => $baseUrl . 'appartementprochedestransports.jpg',
                'category' => 'appartement',
                'amenities' => ['Wifi', 'Cuisine', 'Parking gratuit sur place', 'Climatisation', 'Chauffage', 'Télévision']
            ],
            [
                'title' => 'Petit studio près de la gare',
                'description' => 'Studio pratique et bien situé, parfait pour les voyageurs réguliers.',
                'price' => '400.00',
                'surface' => '18m²',
                'city' => 'Strasbourg',
                'postalcode' => '67000',
                'location' => '22 rue du Maire Kuss',
                'maxOccupants' => '1',
                'image' => $baseUrl . 'Petitstudio.jpg',
                'category' => 'studio',
                'amenities' => ['Cuisine', 'Chauffage', 'Télévision', 'Alarme incendie', 'Privé : patio ou balcon', 'Wifi']
            ],
            [
                'title' => 'Appartement compact en périphérie',
                'description' => 'Appartement moderne et abordable dans un quartier résidentiel calme.',
                'price' => '480.00',
                'surface' => '35m²',
                'city' => 'Lille',
                'postalcode' => '59000',
                'location' => '14 rue Nationale',
                'maxOccupants' => '2',
                'image' => $baseUrl . 'appartement_compact.jpg',
                'category' => 'appartement',
                'amenities' => ['Wifi', 'Cuisine', 'Espace de travail dédié', 'Parking gratuit sur place', 'Chauffage', 'Télévision']
            ],
            [
                'title' => 'Maison de charme à Tours',
                'description' => 'Belle maison avec un charme ancien et des équipements modernes.',
                'price' => '690.00',
                'surface' => '80m²',
                'city' => 'Tours',
                'postalcode' => '37000',
                'location' => '22 Rue Nationale',
                'maxOccupants' => '5',
                'image' => $baseUrl . 'MaisondecharmeàTours.jpg',
                'category' => 'maison',
                'amenities' => [
                    'Vue sur le jardin',
                    'Barbecue',
                    'Cuisine',
                    'Alarme incendie',
                    'Parking gratuit sur place',
                    'Lit bébé'
                ]
            ],
            [
                'title' => 'Studio moderne à petit prix',
                'description' => 'Studio lumineux et bien agencé, idéal pour une première expérience en coliving.',
                'price' => '420.00',
                'surface' => '22m²',
                'city' => 'Nantes',
                'postalcode' => '44000',
                'location' => '5 place Royale',
                'maxOccupants' => '1',
                'image' => $baseUrl . 'studio_moderne.jpg',
                'category' => 'studio',
                'amenities' => ['Cuisine', 'Chauffage', 'Wifi', 'Télévision', 'Espace de travail dédié', 'Alarme incendie']
            ],
                [
                    'title' => 'Superbe appartement au centre-ville',
                    'description' => 'Un bel appartement lumineux et spacieux, idéalement situé au centre-ville.',
                    'price' => '1200.00',
                    'surface' => '80m²',
                    'city' => 'Paris',
                    'postalcode' => '75001',
                    'location' => '12 rue de Rivoli',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'Superbeappartementaucentre-ville.jpg',
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
                    'postalcode' => '69005',
                    'location' => '8 chemin du Vallon',
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
                    'title' => 'Charmant studio au cœur de Strasbourg',
                    'description' => 'Petit studio moderne idéal pour les étudiants ou les jeunes professionnels.',
                    'price' => '300.00',
                    'surface' => '20m²',
                    'city' => 'Strasbourg',
                    'postalcode' => '67000',
                    'location' => '15 Rue des Écrivains',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-strasbourg.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Télévision',
                        'Chauffage',
                        'Espace de travail dédié',
                        'Climatisation'
                    ]
                ],
                [
                    'title' => 'Appartement spacieux avec terrasse à Toulouse',
                    'description' => 'Appartement avec une belle terrasse offrant une vue panoramique.',
                    'price' => '850.00',
                    'surface' => '70m²',
                    'city' => 'Toulouse',
                    'postalcode' => '31000',
                    'location' => '10 Place du Capitole',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'appartement-toulouse.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Cuisine',
                        'Privé : patio ou balcon',
                        'Chauffage',
                        'Piscine'
                    ]
                ],
                [
                    'title' => 'Maison traditionnelle à Colmar',
                    'description' => 'Maison pittoresque avec un grand jardin, idéale pour des vacances en famille.',
                    'price' => '980.00',
                    'surface' => '120m²',
                    'city' => 'Colmar',
                    'postalcode' => '68000',
                    'location' => '25 Rue des Tanneurs',
                    'maxOccupants' => '6',
                    'image' => $baseUrl . 'maison-colmar.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Barbecue',
                        'Climatisation',
                        'Parking gratuit sur place',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Studio calme et lumineux à Rennes',
                    'description' => 'Studio confortable dans une résidence récente, proche des commerces.',
                    'price' => '420.00',
                    'surface' => '25m²',
                    'city' => 'Rennes',
                    'postalcode' => '35000',
                    'location' => '18 Rue Saint-Michel',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-rennes.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Télévision',
                        'Chauffage',
                        'Espace de travail dédié',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Appartement moderne avec vue sur le Rhône à Lyon',
                    'description' => 'Appartement spacieux dans un quartier dynamique, parfait pour une famille.',
                    'price' => '900.00',
                    'surface' => '80m²',
                    'city' => 'Lyon',
                    'postalcode' => '69000',
                    'location' => '20 Quai de Saône',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'appartement-lyon.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Cuisine',
                        'Climatisation',
                        'Espace de travail dédié',
                        'Lit bébé',
                        'Télévision'
                    ]
                ],
                [
                    'title' => 'Maison rustique avec cheminée à Grenoble',
                    'description' => 'Maison chaleureuse avec une ambiance rustique, idéale pour les séjours à la montagne.',
                    'price' => '750.00',
                    'surface' => '100m²',
                    'city' => 'Grenoble',
                    'postalcode' => '38000',
                    'location' => '35 Rue Félix Viallet',
                    'maxOccupants' => '5',
                    'image' => $baseUrl . 'maison-grenoble.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Cheminée',
                        'Cuisine',
                        'Vue sur le jardin',
                        'Barbecue',
                        'Espace de travail dédié',
                        'Parking gratuit sur place'
                    ]
                ],
                [
                    'title' => 'Studio neuf à Montpellier',
                    'description' => 'Studio moderne avec des équipements de haute qualité, proche des transports.',
                    'price' => '500.00',
                    'surface' => '28m²',
                    'city' => 'Montpellier',
                    'postalcode' => '34000',
                    'location' => '8 Place de la Comédie',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-montpellier.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Climatisation',
                        'Chauffage',
                        'Espace de travail dédié',
                        'Lave-linge (Gratuit) dans le bâtiment'
                    ]
                ],
                [
                    'title' => 'Appartement au bord de l’eau à Bordeaux',
                    'description' => 'Bel appartement avec une vue magnifique sur la Garonne.',
                    'price' => '850.00',
                    'surface' => '75m²',
                    'city' => 'Bordeaux',
                    'postalcode' => '33000',
                    'location' => '15 Quai des Chartrons',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'appartement-bordeaux.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Cuisine',
                        'Cheminée',
                        'Espace de travail dédié',
                        'Climatisation'
                    ]
                ],
                [
                    'title' => 'Maison familiale avec piscine à Aix-en-Provence',
                    'description' => 'Maison spacieuse avec une piscine et un jardin privatif.',
                    'price' => '980.00',
                    'surface' => '130m²',
                    'city' => 'Aix-en-Provence',
                    'postalcode' => '13100',
                    'location' => '12 Avenue des Belges',
                    'maxOccupants' => '6',
                    'image' => $baseUrl . 'maison-aix.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Piscine',
                        'Cheminée',
                        'Cuisine',
                        'Vue sur le jardin',
                        'Barbecue',
                        'Parking gratuit sur place'
                    ]
                ],
                [
                    'title' => 'Studio cosy à Annecy',
                    'description' => 'Studio agréable à proximité du lac d’Annecy, parfait pour un séjour relaxant.',
                    'price' => '450.00',
                    'surface' => '30m²',
                    'city' => 'Annecy',
                    'postalcode' => '74000',
                    'location' => '5 Rue de la République',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-annecy.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Télévision',
                        'Cuisine',
                        'Climatisation',
                        'Chauffage',
                        'Barbecue'
                    ]
                ],
                [
                    'title' => 'Appartement avec balcon à Nantes',
                    'description' => 'Appartement moderne avec un balcon et une vue sur la ville.',
                    'price' => '620.00',
                    'surface' => '60m²',
                    'city' => 'Nantes',
                    'postalcode' => '44000',
                    'location' => '20 Rue Crébillon',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'appartement-nantes.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Privé : patio ou balcon',
                        'Climatisation',
                        'Cuisine',
                        'Wifi',
                        'Lave-linge (Gratuit) dans le bâtiment',
                        'Télévision'
                    ]
                    ],
                [
                    'title' => 'Maison de campagne avec jardin',
                    'description' => 'Charmante maison en pleine nature avec un grand jardin.',
                    'price' => '950.00',
                    'surface' => '120m²',
                    'city' => 'Bordeaux',
                    'postalcode' => '33000',
                    'location' => '15 route des Vignes',
                    'maxOccupants' => '6',
                    'image' => $baseUrl . '12355.jpg',
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
                    'postalcode' => '69002',
                    'location' => '25 place Bellecour',
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
                    'postalcode' => '13006',
                    'location' => '10 avenue du Prado',
                    'maxOccupants' => '5',
                    'image' => $baseUrl . 'imagedidi.jpg',
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
                    'title' => 'Studio étudiant abordable',
                    'description' => 'Studio simple et fonctionnel, parfait pour un étudiant ou jeune actif.',
                    'price' => '300.00',
                    'surface' => '20m²',
                    'city' => 'Montpellier',
                    'postalcode' => '34000',
                    'location' => '12 rue du Faubourg',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio_etudiant.jpg',
                    'category' => 'studio',
                    'amenities' => ['Wifi', 'Chauffage', 'Cuisine', 'Espace de travail dédié', 'Lave-linge (Gratuit) dans le bâtiment', 'Alarme incendie']
                ],
                [
                    'title' => 'Appartement partagé pas cher',
                    'description' => 'Chambre privée dans un appartement partagé, à proximité des transports.',
                    'price' => '250.00',
                    'surface' => '15m²',
                    'city' => 'Lille',
                    'postalcode' => '59000',
                    'location' => '25 avenue Foch',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'appartement_partage.jpg',
                    'category' => 'appartement',
                    'amenities' => ['Wifi', 'Cuisine', 'Climatisation', 'Télévision', 'Chauffage', 'Lave-linge (Gratuit) dans le bâtiment']
                ],
                [
                    'title' => 'Studio cosy et pas cher',
                    'description' => 'Studio bien aménagé à un prix très abordable pour un confort optimal.',
                    'price' => '320.00',
                    'surface' => '22m²',
                    'city' => 'Clermont-Ferrand',
                    'postalcode' => '63000',
                    'location' => '8 boulevard François Mitterrand',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio_cosy.jpg',
                    'category' => 'studio',
                    'amenities' => ['Wifi', 'Chauffage', 'Cuisine', 'Télévision', 'Barbecue', 'Espace de travail dédié']
                ],
                [
                    'title' => 'Petite maison en campagne',
                    'description' => 'Maison économique et paisible, idéale pour se détendre loin de la ville.',
                    'price' => '350.00',
                    'surface' => '45m²',
                    'city' => 'Angers',
                    'postalcode' => '49000',
                    'location' => '6 chemin de la Vallée',
                    'maxOccupants' => '2',
                    'image' => $baseUrl . 'maison_campagne.jpg',
                    'category' => 'maison',
                    'amenities' => ['Wifi', 'Chauffage', 'Cuisine', 'Privé : patio ou balcon', 'Télévision', 'Parking gratuit sur place']
                ],
                [
                    'title' => 'Chambre économique au centre-ville',
                    'description' => 'Chambre privée au cœur du centre-ville, avec accès rapide aux commodités.',
                    'price' => '200.00',
                    'surface' => '18m²',
                    'city' => 'Rennes',
                    'postalcode' => '35000',
                    'location' => '10 rue Saint-Georges',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'chambre_economique.jpg',
                    'category' => 'appartement',
                    'amenities' => ['Wifi', 'Cuisine', 'Chauffage', 'Espace de travail dédié', 'Lave-linge (Gratuit) dans le bâtiment', 'Alarme incendie']
                ],
                [
                    'title' => 'Loft en centre historique',
                    'description' => 'Magnifique loft avec vue imprenable sur le centre historique.',
                    'price' => '2000.00',
                    'surface' => '150m²',
                    'city' => 'Nice',
                    'postalcode' => '06000',
                    'location' => '5 promenade des Anglais',
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
                    'title' => 'Studio cosy au coeur de Lille',
                    'description' => 'Un charmant studio bien aménagé, proche des commerces et transports.',
                    'price' => '450.00',
                    'surface' => '25m²',
                    'city' => 'Lille',
                    'postalcode' => '59000',
                    'location' => '5 Place Rihour',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-lille.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Chauffage',
                        'Bureau',
                        'Cuisine',
                        'Télévision',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Petite maison avec terrasse à Rouen',
                    'description' => 'Maison individuelle avec terrasse privée, idéale pour une personne ou un couple.',
                    'price' => '400.00',
                    'surface' => '35m²',
                    'city' => 'Rouen',
                    'postalcode' => '76000',
                    'location' => '12 Rue du Gros-Horloge',
                    'maxOccupants' => '2',
                    'image' => $baseUrl . 'maison-rouen.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Parking gratuit sur place',
                        'Cuisine',
                        'Lave-linge (Gratuit) dans le bâtiment',
                        'Télévision',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Appartement économique à Nancy',
                    'description' => 'Appartement lumineux et fonctionnel, idéal pour un étudiant ou un jeune professionnel.',
                    'price' => '380.00',
                    'surface' => '40m²',
                    'city' => 'Nancy',
                    'postalcode' => '54000',
                    'location' => '15 Rue Stanislas',
                    'maxOccupants' => '2',
                    'image' => $baseUrl . 'appartement-nancy.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Climatisation',
                        'Cuisine',
                        'Cheminée',
                        'Bureau',
                        'Barbecue'
                    ]
                ],
                [
                    'title' => 'Studio lumineux proche du port de Brest',
                    'description' => 'Petit studio bien équipé, idéal pour une personne seule, avec vue sur le port.',
                    'price' => '320.00',
                    'surface' => '22m²',
                    'city' => 'Brest',
                    'postalcode' => '29200',
                    'location' => '8 Quai Commandant Malbert',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-brest.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Chauffage',
                        'Télévision',
                        'Cuisine',
                        'Espace de travail dédié',
                        'Privé : patio ou balcon'
                    ]
                ],
                [
                    'title' => 'Appartement partagé dans un quartier calme à Dijon',
                    'description' => 'Chambre privée dans un appartement spacieux, à proximité des transports en commun.',
                    'price' => '250.00',
                    'surface' => '50m²',
                    'city' => 'Dijon',
                    'postalcode' => '21000',
                    'location' => '20 Avenue de la Gare',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'appartement-dijon.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Climatisation',
                        'Cuisine',
                        'Sèche-linge (Gratuit) dans le bâtiment',
                        'Lit bébé',
                        'Salle de sport'
                    ]
                    ],
                    [
                        'title' => 'Studio moderne proche du centre à Nantes',
                        'description' => 'Studio entièrement rénové, idéal pour une personne seule, proche des commerces.',
                        'price' => '450.00',
                        'surface' => '28m²',
                        'city' => 'Nantes',
                        'postalcode' => '44000',
                        'location' => '10 Rue de la République',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio-nantes.jpg',
                        'category' => 'studio',
                        'amenities' => [
                            'Wifi',
                            'Chauffage',
                            'Bureau',
                            'Cuisine',
                            'Télévision',
                            'Climatisation'
                        ]
                    ],
                    [
                        'title' => 'Appartement lumineux dans le vieux Nice',
                        'description' => 'Appartement charmant, idéal pour un couple, avec vue sur la vieille ville.',
                        'price' => '750.00',
                        'surface' => '55m²',
                        'city' => 'Nice',
                        'postalcode' => '06000',
                        'location' => '5 Place Garibaldi',
                        'maxOccupants' => '2',
                        'image' => $baseUrl . 'appartement-nice.jpg',
                        'category' => 'appartement',
                        'amenities' => [
                            'Wifi',
                            'Climatisation',
                            'Cheminée',
                            'Cuisine',
                            'Vue sur le jardin',
                            'Privé : patio ou balcon'
                        ]
                    ],
                    [
                        'title' => 'Maison cosy avec jardin à Montpellier',
                        'description' => 'Maison idéale pour une petite famille, avec un jardin pour se détendre.',
                        'price' => '650.00',
                        'surface' => '70m²',
                        'city' => 'Montpellier',
                        'postalcode' => '34000',
                        'location' => '18 Rue Foch',
                        'maxOccupants' => '4',
                        'image' => $baseUrl . 'maison-montpellier.jpg',
                        'category' => 'maison',
                        'amenities' => [
                            'Vue sur le jardin',
                            'Barbecue',
                            'Cuisine',
                            'Lave-linge (Gratuit) dans le bâtiment',
                            'Alarme incendie',
                            'Climatisation'
                        ]
                    ],
                    [
                        'title' => 'Studio économique près de la gare à Marseille',
                        'description' => 'Petit studio pratique, idéal pour une personne seule ou un étudiant.',
                        'price' => '300.00',
                        'surface' => '20m²',
                        'city' => 'Marseille',
                        'postalcode' => '13001',
                        'location' => '22 Rue Saint-Charles',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio-marseille.jpg',
                        'category' => 'studio',
                        'amenities' => [
                            'Wifi',
                            'Télévision',
                            'Cuisine',
                            'Espace de travail dédié',
                            'Sèche-linge (Gratuit) dans le bâtiment',
                            'Chauffage'
                        ]
                    ],
                    [
                        'title' => 'Appartement spacieux à Strasbourg',
                        'description' => 'Bel appartement spacieux et lumineux, proche des institutions européennes.',
                        'price' => '800.00',
                        'surface' => '65m²',
                        'city' => 'Strasbourg',
                        'postalcode' => '67000',
                        'location' => '7 Rue de la Paix',
                        'maxOccupants' => '3',
                        'image' => $baseUrl . 'appartement-strasbourg.jpg',
                        'category' => 'appartement',
                        'amenities' => [
                            'Wifi',
                            'Cheminée',
                            'Barbecue',
                            'Cuisine',
                            'Climatisation',
                            'Lit bébé'
                        ]
                    ],
                    [
                        'title' => 'Maison traditionnelle à Toulouse',
                        'description' => 'Maison charmante et authentique, idéale pour une famille.',
                        'price' => '700.00',
                        'surface' => '85m²',
                        'city' => 'Toulouse',
                        'postalcode' => '31000',
                        'location' => '12 Rue Alsace-Lorraine',
                        'maxOccupants' => '5',
                        'image' => $baseUrl . 'maison-toulouse.jpg',
                        'category' => 'maison',
                        'amenities' => [
                            'Piscine',
                            'Cuisine',
                            'Parking gratuit sur place',
                            'Télévision',
                            'Alarme incendie',
                            'Bureau'
                        ]
                    ],
                    [
                        'title' => 'Studio pratique à Lyon',
                        'description' => 'Studio bien aménagé, parfait pour les étudiants ou les jeunes actifs.',
                        'price' => '350.00',
                        'surface' => '25m²',
                        'city' => 'Lyon',
                        'postalcode' => '69001',
                        'location' => '8 Place Bellecour',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio-lyon.jpg',
                        'category' => 'studio',
                        'amenities' => [
                            'Wifi',
                            'Climatisation',
                            'Cuisine',
                            'Bureau',
                            'Espace de travail dédié',
                            'Télévision'
                        ]
                    ],
                    [
                        'title' => 'Appartement moderne à Bordeaux',
                        'description' => 'Appartement récemment rénové, avec un design moderne et épuré.',
                        'price' => '600.00',
                        'surface' => '50m²',
                        'city' => 'Bordeaux',
                        'postalcode' => '33000',
                        'location' => '15 Rue Sainte-Catherine',
                        'maxOccupants' => '2',
                        'image' => $baseUrl . 'appartement-bordeau.jpg',
                        'category' => 'appartement',
                        'amenities' => [
                            'Wifi',
                            'Cuisine',
                            'Chauffage',
                            'Cheminée',
                            'Barbecue',
                            'Vue sur le jardin'
                        ]
                    ],
                    [
                        'title' => 'Maison de village à Avignon',
                        'description' => 'Maison confortable et chaleureuse, située dans un village typique.',
                        'price' => '500.00',
                        'surface' => '75m²',
                        'city' => 'Avignon',
                        'postalcode' => '84000',
                        'location' => '10 Rue des Teinturiers',
                        'maxOccupants' => '4',
                        'image' => $baseUrl . 'maison-avignon.jpg',
                        'category' => 'maison',
                        'amenities' => [
                            'Wifi',
                            'Cheminée',
                            'Cuisine',
                            'Lave-linge (Gratuit) dans le bâtiment',
                            'Sèche-linge (Gratuit) dans le bâtiment',
                            'Télévision'
                        ]
                    ],
                    [
                        'title' => 'Studio pratique à Reims',
                        'description' => 'Petit studio, idéal pour un étudiant, proche de l’université.',
                        'price' => '280.00',
                        'surface' => '18m²',
                        'city' => 'Reims',
                        'postalcode' => '51100',
                        'location' => '6 Rue de Vesle',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio-reims.jpg',
                        'category' => 'studio',
                        'amenities' => [
                            'Wifi',
                            'Télévision',
                            'Cuisine',
                            'Climatisation',
                            'Espace de travail dédié',
                            'Lit bébé'
                        ]
                        ],
                [
                    'title' => 'Maison avec vue sur la rivière',
                    'description' => 'Belle maison familiale avec jardin donnant sur la rivière.',
                    'price' => '1250.00',
                    'surface' => '95m²',
                    'city' => 'Rouen',
                    'postalcode' => '76000',
                    'location' => '20 rue Saint-Sever',
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
                    'postalcode' => '75005',
                    'location' => '7 rue Soufflot',
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
                    'postalcode' => '59000',
                    'location' => '15 rue Nationale',
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
                    'postalcode' => '21000',
                    'location' => '3 boulevard Carnot',
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
                    'postalcode' => '51100',
                    'location' => '8 rue Chanzy',
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
                    'title' => 'Appartement moderne avec balcon à Lille',
                    'description' => 'Appartement lumineux et bien équipé avec un balcon donnant sur un parc.',
                    'price' => '650.00',
                    'surface' => '50m²',
                    'city' => 'Lille',
                    'postalcode' => '59000',
                    'location' => '12 Rue Nationale',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'appartement-lille.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Climatisation',
                        'Wifi',
                        'Cuisine',
                        'Vue sur le jardin',
                        'Parking gratuit sur place',
                        'Cheminée'
                    ]
                ],
                [
                    'title' => 'Studio fonctionnel à Grenoble',
                    'description' => 'Petit studio idéal pour étudiant, proche de toutes commodités et des transports.',
                    'price' => '420.00',
                    'surface' => '25m²',
                    'city' => 'Grenoble',
                    'postalcode' => '38000',
                    'location' => '5 Rue Félix Viallet',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-grenoble.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Espace de travail dédié',
                        'Chauffage',
                        'Lave-linge (Gratuit) dans le bâtiment',
                        'Télévision'
                    ]
                ],
                [
                    'title' => 'Maison avec jardin à La Rochelle',
                    'description' => 'Charmante maison avec un grand jardin, idéale pour une famille.',
                    'price' => '700.00',
                    'surface' => '90m²',
                    'city' => 'La Rochelle',
                    'postalcode' => '17000',
                    'location' => '8 Rue Saint-Nicolas',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'maison-larochelle.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Barbecue',
                        'Cuisine',
                        'Piscine',
                        'Alarme incendie',
                        'Télévision'
                    ]
                ],
                [
                    'title' => 'Appartement cosy à Clermont-Ferrand',
                    'description' => 'Appartement charmant avec une décoration moderne, idéal pour un couple.',
                    'price' => '570.00',
                    'surface' => '45m²',
                    'city' => 'Clermont-Ferrand',
                    'postalcode' => '63000',
                    'location' => '10 Place de Jaude',
                    'maxOccupants' => '2',
                    'image' => $baseUrl . 'appartement-clermont.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Chauffage',
                        'Cuisine',
                        'Lit bébé',
                        'Privé : patio ou balcon',
                        'Espace de travail dédié'
                    ]
                ],
                [
                    'title' => 'Studio neuf à Pau',
                    'description' => 'Studio tout confort, récemment rénové, parfait pour une personne seule.',
                    'price' => '450.00',
                    'surface' => '20m²',
                    'city' => 'Pau',
                    'postalcode' => '64000',
                    'location' => '3 Boulevard des Pyrénées',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-pau.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Télévision',
                        'Climatisation',
                        'Chauffage',
                        'Cuisine',
                        'Bureau'
                    ]
                ],
                
                [
                    'title' => 'Appartement avec vue sur la mer à Biarritz',
                    'description' => 'Appartement moderne avec une vue imprenable sur l’océan.',
                    'price' => '650.00',
                    'surface' => '55m²',
                    'city' => 'Biarritz',
                    'postalcode' => '64200',
                    'location' => '14 Avenue de la Plage',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'appartement-biarritz.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Vue sur le jardin',
                        'Climatisation',
                        'Cuisine',
                        'Cheminée',
                        'Barbecue',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Studio cosy à Dijon',
                    'description' => 'Petit studio idéalement situé pour explorer la ville.',
                    'price' => '400.00',
                    'surface' => '22m²',
                    'city' => 'Dijon',
                    'postalcode' => '21000',
                    'location' => '7 Rue de la Liberté',
                    'maxOccupants' => '1',
                    'image' => $baseUrl . 'studio-dijon.jpg',
                    'category' => 'studio',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Télévision',
                        'Espace de travail dédié',
                        'Climatisation',
                        'Chauffage'
                    ]
                ],
                [
                    'title' => 'Maison en pierre à Perpignan',
                    'description' => 'Maison traditionnelle avec un patio et un barbecue, parfaite pour l’été.',
                    'price' => '690.00',
                    'surface' => '85m²',
                    'city' => 'Perpignan',
                    'postalcode' => '66000',
                    'location' => '5 Rue du Castillet',
                    'maxOccupants' => '4',
                    'image' => $baseUrl . 'maison-perpignan.jpg',
                    'category' => 'maison',
                    'amenities' => [
                        'Barbecue',
                        'Cuisine',
                        'Vue sur le jardin',
                        'Cheminée',
                        'Piscine',
                        'Alarme incendie'
                    ]
                ],
                [
                    'title' => 'Appartement lumineux à Angers',
                    'description' => 'Appartement spacieux avec des fenêtres panoramiques, idéal pour une famille.',
                    'price' => '600.00',
                    'surface' => '60m²',
                    'city' => 'Angers',
                    'postalcode' => '49000',
                    'location' => '9 Place du Ralliement',
                    'maxOccupants' => '3',
                    'image' => $baseUrl . 'appartement-angers.jpg',
                    'category' => 'appartement',
                    'amenities' => [
                        'Wifi',
                        'Cuisine',
                        'Chauffage',
                        'Télévision',
                        'Privé : patio ou balcon',
                        'Lit bébé'
                    ]
                    ],
                [
                    'title' => 'Appartement proche du parc',
                    'description' => 'Appartement lumineux à deux pas du parc municipal.',
                    'price' => '900.00',
                    'surface' => '60m²',
                    'city' => 'Orléans',
                    'postalcode' => '45000',
                    'location' => '18 rue Jeanne d\'Arc',
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
                
                    [
                        'title' => 'Charmante maison avec piscine',
                        'description' => 'Maison spacieuse et lumineuse avec une grande piscine et jardin.',
                        'price' => '1800.00',
                        'surface' => '150m²',
                        'city' => 'Toulouse',
                        'postalcode' => '31000',
                        'location' => '25 rue des Lilas',
                        'maxOccupants' => '6',
                        'image' => $baseUrl . 'maison2.jpg',
                        'category' => 'maison',
                        'amenities' => ['Piscine', 'Barbecue', 'Climatisation', 'Parking gratuit sur place', 'Vue sur le jardin', 'Cheminée']
                    ],
                    [
                        'title' => 'Studio cosy au cœur de la ville',
                        'description' => 'Petit studio moderne et fonctionnel, idéal pour un séjour en solo ou en couple.',
                        'price' => '500.00',
                        'surface' => '25m²',
                        'city' => 'Lille',
                        'postalcode' => '59000',
                        'location' => '14 place de la République',
                        'maxOccupants' => '2',
                        'image' => $baseUrl . 'studio2.jpg',
                        'category' => 'studio',
                        'amenities' => ['Wifi', 'Cuisine', 'Chauffage', 'Espace de travail dédié', 'Lave-linge (Gratuit) dans le bâtiment', 'Télévision']
                    ],
                    [
                        'title' => 'Appartement avec terrasse et vue imprenable',
                        'description' => 'Un appartement moderne avec une grande terrasse offrant une vue panoramique.',
                        'price' => '1350.00',
                        'surface' => '90m²',
                        'city' => 'Strasbourg',
                        'postalcode' => '67000',
                        'location' => '3 avenue des Vosges',
                        'maxOccupants' => '4',
                        'image' => $baseUrl . 'appartement3.jpg',
                        'category' => 'appartement',
                        'amenities' => ['Climatisation', 'Parking gratuit sur place', 'Salle de sport', 'Jacuzzi', 'Vue sur le jardin', 'Cuisine']
                    ],
                    [
                        'title' => 'Maison familiale avec jardin',
                        'description' => 'Maison idéale pour une famille, avec un grand jardin et des équipements modernes.',
                        'price' => '2000.00',
                        'surface' => '180m²',
                        'city' => 'Nantes',
                        'postalcode' => '44000',
                        'location' => '8 rue de la Loire',
                        'maxOccupants' => '8',
                        'image' => $baseUrl . 'maison3.jpg',
                        'category' => 'maison',
                        'amenities' => ['Barbecue', 'Piscine', 'Climatisation', 'Lit bébé', 'Alarme incendie', 'Parking gratuit sur place']
                    ],
                    [
                        'title' => 'Studio moderne avec balcon',
                        'description' => 'Un studio bien aménagé avec balcon, parfait pour un séjour professionnel ou touristique.',
                        'price' => '700.00',
                        'surface' => '35m²',
                        'city' => 'Montpellier',
                        'postalcode' => '34000',
                        'location' => '22 rue du Marché',
                        'maxOccupants' => '2',
                        'image' => $baseUrl . 'studio3.jpg',
                        'category' => 'studio',
                        'amenities' => ['Cuisine', 'Climatisation', 'Espace de travail dédié', 'Télévision', 'Privé : patio ou balcon', 'Chauffage']
                    ],

                    [
                        'title' => 'Appartement lumineux près des commerces',
                        'description' => 'Un appartement spacieux et lumineux, idéal pour les petits budgets dans une zone bien desservie.',
                        'price' => '750.00',
                        'surface' => '55m²',
                        'city' => 'Lyon',
                        'postalcode' => '69002',
                        'location' => '35 rue Victor Hugo',
                        'maxOccupants' => '2',
                        'image' => $baseUrl . 'appartement_commerce.jpg',
                        'category' => 'appartement',
                        'amenities' => ['Wifi', 'Cuisine', 'Climatisation', 'Chauffage', 'Télévision', 'Barbecue']
                    ],
                    [
                        'title' => 'Studio moderne et fonctionnel',
                        'description' => 'Studio bien équipé, parfait pour un étudiant ou jeune actif avec un accès rapide au centre-ville.',
                        'price' => '600.00',
                        'surface' => '28m²',
                        'city' => 'Nice',
                        'postalcode' => '06000',
                        'location' => '10 avenue Jean Médecin',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio_fonctionnel.jpg',
                        'category' => 'studio',
                        'amenities' => ['Cuisine', 'Climatisation', 'Wifi', 'Chauffage', 'Espace de travail dédié', 'Piscine']
                    ],
                    [
                        'title' => 'Maison cosy en périphérie',
                        'description' => 'Charmante maison au calme, idéale pour une petite famille ou un couple.',
                        'price' => '800.00',
                        'surface' => '70m²',
                        'city' => 'Marseille',
                        'postalcode' => '13011',
                        'location' => '42 chemin des Vallons',
                        'maxOccupants' => '4',
                        'image' => $baseUrl . 'maison_cosy.jpg',
                        'category' => 'maison',
                        'amenities' => ['Wifi', 'Climatisation', 'Cuisine', 'Privé : patio ou balcon', 'Télévision', 'Parking gratuit sur place']
                    ],
                    [
                        'title' => 'Appartement rénové avec balcon',
                        'description' => 'Appartement récemment rénové avec un balcon offrant une vue agréable.',
                        'price' => '700.00',
                        'surface' => '60m²',
                        'city' => 'Toulouse',
                        'postalcode' => '31000',
                        'location' => '20 allée Jean Jaurès',
                        'maxOccupants' => '3',
                        'image' => $baseUrl . 'appartement_balcon.jpg',
                        'category' => 'appartement',
                        'amenities' => ['Cuisine', 'Climatisation', 'Barbecue', 'Télévision', 'Chauffage', 'Alarme incendie']
                    ],
                    [
                        'title' => 'Studio pratique en centre-ville',
                        'description' => 'Studio compact et pratique, situé au cœur du centre-ville pour une vie urbaine dynamique.',
                        'price' => '550.00',
                        'surface' => '30m²',
                        'city' => 'Bordeaux',
                        'postalcode' => '33000',
                        'location' => '15 cours de l’Intendance',
                        'maxOccupants' => '1',
                        'image' => $baseUrl . 'studio_centreville.jpg',
                        'category' => 'studio',
                        'amenities' => ['Wifi', 'Cuisine', 'Chauffage', 'Télévision', 'Espace de travail dédié', 'Lave-linge (Gratuit) dans le bâtiment']
                    ],
                        [
                            'title' => 'Maison en bord de mer',
                            'description' => 'Profitez de cette magnifique maison avec une vue imprenable sur la mer.',
                            'price' => '2500.00',
                            'surface' => '200m²',
                            'city' => 'Marseille',
                            'postalcode' => '13007',
                            'location' => '10 quai des Belges',
                            'maxOccupants' => '8',
                            'image' => $baseUrl . 'maison_bord_mer.jpg',
                            'category' => 'maison',
                            'amenities' => ['Vue sur le jardin', 'Parking gratuit sur place', 'Climatisation', 'Piscine', 'Jacuzzi', 'Cheminée']
                        ],
                        [
                            'title' => 'Appartement duplex moderne',
                            'description' => 'Superbe duplex moderne en plein cœur de la ville, proche de toutes commodités.',
                            'price' => '1700.00',
                            'surface' => '120m²',
                            'city' => 'Nice',
                            'postalcode' => '06000',
                            'location' => '2 avenue Jean Médecin',
                            'maxOccupants' => '6',
                            'image' => $baseUrl . 'duplex_nice.jpg',
                            'category' => 'appartement',
                            'amenities' => ['Wifi', 'Salle de sport', 'Télévision', 'Espace de travail dédié', 'Climatisation', 'Cuisine']
                        ],
                        [
                            'title' => 'Studio lumineux dans quartier calme',
                            'description' => 'Studio entièrement équipé, idéal pour une escapade dans un quartier paisible.',
                            'price' => '400.00',
                            'surface' => '20m²',
                            'city' => 'Lyon',
                            'postalcode' => '69006',
                            'location' => '33 rue Garibaldi',
                            'maxOccupants' => '1',
                            'image' => $baseUrl . 'studio_calme.jpg',
                            'category' => 'studio',
                            'amenities' => ['Cuisine', 'Climatisation', 'Chauffage', 'Privé : patio ou balcon', 'Alarme incendie', 'Télévision']
                        ],
                        [
                            'title' => 'Maison avec grande terrasse et jardin',
                            'description' => 'Maison spacieuse parfaite pour des vacances en famille avec une grande terrasse.',
                            'price' => '2200.00',
                            'surface' => '170m²',
                            'city' => 'Bordeaux',
                            'postalcode' => '33000',
                            'location' => '5 rue Sainte-Catherine',
                            'maxOccupants' => '7',
                            'image' => $baseUrl . 'maison_terrasse.jpg',
                            'category' => 'maison',
                            'amenities' => ['Barbecue', 'Piscine', 'Climatisation', 'Lit bébé', 'Station de recharge pour véhicules électriques', 'Parking gratuit sur place']
                        ],
                        [
                            'title' => 'Studio élégant avec accès rapide au centre',
                            'description' => 'Studio moderne avec toutes les commodités, à deux pas des transports en commun.',
                            'price' => '600.00',
                            'surface' => '28m²',
                            'city' => 'Rennes',
                            'postalcode' => '35000',
                            'location' => '7 place de Bretagne',
                            'maxOccupants' => '2',
                            'image' => $baseUrl . 'studio_elegant.jpg',
                            'category' => 'studio',
                            'amenities' => ['Cuisine', 'Télévision', 'Wifi', 'Espace de travail dédié', 'Chauffage', 'Climatisation']
                        ]
                    ];
                    
                
                
            
            
   
            // Ajoutez d'autres annonces ici avec leurs amenities

        // Création des annonces avec les images, catégories et amenities
        foreach ($annoncesData as $index => $data) {
            $annonce = new Annonce();
            $annonce->setTitle($data['title'])
                    ->setDescription($data['description'])
                    ->setPrice($data['price'])
                    ->setSurface($data['surface'])
                    ->setCity($data['city'])
                    ->setLocation($data['location'])
                    ->setPostalCode($data['postalcode'])
                    ->setMaxOccupants($data['maxOccupants'])
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable());
        
            // Créer une image principale pour l'annonce
            $image = new Image();
            $image->setName($data['image']);
            $annonce->setImage($image);
        
            // Associer la catégorie
            $annonce->setCategory($categories[$data['category']]);
        
              // Ajouter 6 images uniques à `ImageList`
            for ($i = 1; $i <= 6; $i++) {
             $imageList = new \App\Entity\ImageList();
             // Générer un chemin unique pour chaque image
            $uniqueImageName = "http://localhost:8000/images/image_{$index}_{$i}.jpg";
            $imageList->setName($uniqueImageName);
            $imageList->setAnnonce($annonce);

            $manager->persist($imageList);
        }
        
            // Associer les amenities
            foreach ($data['amenities'] as $amenityName) {
                $annonce->addAmenity($amenities[$amenityName]);
            }
        
            // Persister l'image principale et l'annonce
            $manager->persist($image);
            $manager->persist($annonce);
        }
        
        // Enregistrer en base de données
        $manager->flush();
    
    }}
    