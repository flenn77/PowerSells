<?php

// src/DataFixtures/AppFixtures.php
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

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->safeEmail)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhone($faker->randomNumber(9))
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setRoles(['ROLE_CAISSIER']);

            $password = $this->passwordEncoder->encodePassword($user, 'password');
            $user->setPassword($password);

            $manager->persist($user);
        }
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setEmail($faker->unique()->safeEmail)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhone($faker->randomNumber(9))
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setRoles(['ROLE_MANAGER']);

            $password = $this->passwordEncoder->encodePassword($user, 'password123');
            $user->setPassword($password);

            $manager->persist($user);
        }
        // Créer les catégories
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->setCategoryName($faker->word)
                ->setActive($faker->boolean)
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setUpdatedAt($faker->dateTimeThisDecade);
            $manager->persist($category);

            // Créer les produits
            for ($j = 0; $j < 10; $j++) {
                $product = new Product();
                $product->setProductName($faker->word)
                    ->setPrice($faker->randomFloat(2, 1, 100))
                    ->setActive($faker->boolean)
                    ->setDescription($faker->text)
                    ->setCreatedAt($faker->dateTimeThisDecade)
                    ->setUpdatedAt($faker->dateTimeThisDecade)
                    ->setCategory($category)
                    ->setStock($faker->randomFloat(2, 1, 100));
                $manager->persist($product);
            }
        }
        $manager->flush();
    }
}
