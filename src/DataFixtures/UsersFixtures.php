<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $userData = [
            [
                'role' => 'ROLE_CAISSIER',
                'count' => 5,
                'password' => 'caissier123',
                'users' => [
                    ['email' => 'yani@caisse.fr', 'firstName' => 'yani', 'lastName' => 'yani', 'phone' => '123456789'],
                    ['email' => 'islem@caisse.fr', 'firstName' => 'islem', 'lastName' => 'islem', 'phone' => '987654321'],
                    ['email' => 'mourad@caisse.fr', 'firstName' => 'mourad', 'lastName' => 'mourad', 'phone' => '987654321'],
                ],
            ],
            [
                'role' => 'ROLE_MANAGER',
                'count' => 2,
                'password' => 'manager123',
                'users' => [
                    ['email' => 'yani@manager.fr', 'firstName' => 'yani', 'lastName' => 'yani', 'phone' => '123456789'],
                    ['email' => 'islem@manager.fr', 'firstName' => 'islem', 'lastName' => 'islem', 'phone' => '987654321'],
                    ['email' => 'mourad@manager.fr', 'firstName' => 'mourad', 'lastName' => 'mourad', 'phone' => '987654321'],
                ],
            ],
        ];
        
        foreach ($userData as $data) {
            foreach ($data['users'] as $userDetails) {
                $user = new User();
                $user->setEmail($userDetails['email'])
                    ->setFirstName($userDetails['firstName'])
                    ->setLastName($userDetails['lastName'])
                    ->setPhone($userDetails['phone'])
                    ->setCreatedAt($faker->dateTimeThisDecade)
                    ->setRoles([$data['role']]);
        
                $password = $this->passwordEncoder->encodePassword($user, $data['password']);
                $user->setPassword($password);
        
                $manager->persist($user);
            }
        }
        // Créer les catégories
        $categoriesData = [
            // Fruits
            ['Fruits', 'Chiquita', 2.50, 'Bananes', 150],
            ['Fruits', 'Pink Lady', 1.50, 'Pommes', 100],
            ['Fruits', 'Del Monte', 2.00, 'Ananas', 120],
            ['Fruits', 'Dole', 1.20, 'Raisins', 130],
            ['Fruits', 'Sun-Maid', 2.10, 'Raisins secs', 140],
            
            // Légumes
            ['Légumes', 'Green Giant', 1.20, 'Maïs', 150],
            ['Légumes', 'Birds Eye', 2.00, 'Petits pois', 100],
            ['Légumes', 'McCain', 1.50, 'Frites', 180],
            ['Légumes', 'Heinz', 1.80, 'Haricots', 110],
            ['Légumes', 'Del Monte', 1.90, 'Tomates en conserve', 140],
            
            // Viandes
            ['Viandes', 'Oscar Mayer', 5.00, 'Saucisses', 50],
            ['Viandes', 'Tyson Foods', 7.00, 'Poulet', 30],
            ['Viandes', 'Smithfield', 6.00, 'Jambon', 40],
            ['Viandes', 'Hormel', 5.50, 'Bacon', 60],
            ['Viandes', 'Perdue', 6.50, 'Dinde', 35],
            
            // Poissons et fruits de mer
            ['Poissons et fruits de mer', 'Red Lobster', 8.50, 'Homard', 30],
            ['Poissons et fruits de mer', 'Long John Silver\'s', 9.00, 'Fish & Chips', 50],
            ['Poissons et fruits de mer', 'Bumble Bee', 7.50, 'Thon en conserve', 80],
            ['Poissons et fruits de mer', 'Chicken of the Sea', 7.00, 'Saumon en conserve', 60],
            ['Poissons et fruits de mer', 'Gorton\'s', 8.00, 'Filets de poisson', 70],
            
            // Produits laitiers
            ['Produits laitiers', 'Danone', 0.90, 'Yaourt', 200],
            ['Produits laitiers', 'Kraft Heinz', 3.00, 'Fromage', 50],
            ['Produits laitiers', 'Nestlé', 2.00, 'Lait en poudre', 120],
            ['Produits laitiers', 'Chobani', 1.50, 'Yaourt grec', 130],
            ['Produits laitiers', 'Lactalis', 2.50, 'Lait', 180],
            
            // Boulangerie et pâtisserie
            ['Boulangerie et pâtisserie', 'Panera Bread', 1.50, 'Pain', 100],
            ['Boulangerie et pâtisserie', 'Dunkin\' Donuts', 2.00, 'Beignets', 150],
            ['Boulangerie et pâtisserie', 'Bimbo Bakeries', 2.50, 'Gâteaux', 120],
            ['Boulangerie et pâtisserie', 'Krispy Kreme', 1.80, 'Donuts', 140],
            ['Boulangerie et pâtisserie', 'Hostess', 2.30, 'Twinkies', 110],
            
            // Boissons
            ['Boissons', 'Coca-Cola', 0.50, 'Soda', 500],
            ['Boissons', 'PepsiCo', 0.70, 'Pepsi', 450],
            ['Boissons', 'Nestlé', 1.00, 'Eau en bouteille', 400],
            ['Boissons', 'Dr Pepper Snapple Group', 0.80, 'Dr Pepper', 430],
            ['Boissons', 'Red Bull', 2.00, 'Boisson énergisante', 220],
            
            // Épicerie
            ['Épicerie', 'Unilever', 1.50, 'Sauce tomate', 200],
            ['Épicerie', 'Procter & Gamble', 2.00, 'Céréales', 220],
            ['Épicerie', 'General Mills', 1.20, 'Farine', 210],
            ['Épicerie', 'Kellogg\'s', 2.30, 'Céréales', 180],
            ['Épicerie', 'Mars', 1.80, 'Barres chocolatées', 190],
            
            // Snacks
            ['Snacks', 'Frito-Lay', 2.00, 'Chips', 100],
            ['Snacks', 'Mondelez International', 2.50, 'Biscuits', 150],
            ['Snacks', 'Hershey', 1.80, 'Chocolat', 130],
            ['Snacks', 'Ferrero', 2.60, 'Nutella', 120],
            ['Snacks', 'Mars', 2.00, 'M&M\'s', 140],
            
            // Produits surgelés
            ['Produits surgelés', 'Nestlé', 3.00, 'Glaces', 50],
            ['Produits surgelés', 'Unilever', 3.50, 'Poissons panés', 100],
            ['Produits surgelés', 'McCain', 2.50, 'Légumes surgelés', 150],
            ['Produits surgelés', 'Tyson Foods', 4.00, 'Poulet surgelé', 80],
            ['Produits surgelés', 'General Mills', 3.00, 'Pizza surgelée', 90],
        ];
        

        $categories = [];
        foreach ($categoriesData as [$categoryName, $productName, $price, $description, $stock]) {
            if (!isset($categories[$categoryName])) {
                $category = new Category();
                $category->setCategoryName($categoryName)
                    ->setActive(true)
                    ->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime());
                $manager->persist($category);
                $categories[$categoryName] = $category;
            }

            $product = new Product();
            $product->setCategory($categories[$categoryName])
                ->setProductName($productName)
                ->setPrice($price)
                ->setActive(true)
                ->setDescription($description)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime())
                ->setStock($stock);
            $manager->persist($product);
        }
        $manager->flush();
    }
}



