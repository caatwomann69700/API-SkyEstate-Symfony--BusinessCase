<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un utilisateur admin
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));
        $admin->setLastname('Admin');
        $admin->setFirstname('Administrator');
        $admin->setBirthdate(new \DateTime('1980-01-01'));
        $admin->setPhone('1234567890');
        $admin->setGender('Male');
        $admin->setAddress('123 Admin Street');
        $admin->setCity('AdminCity');
        $admin->setCountry('AdminLand');
        $admin->setCreatedAt(new \DateTime());
        $admin->setUpdatedAt(new \DateTime());
        $manager->persist($admin);

        // Création de plusieurs utilisateurs standards
        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->setEmail("user$i@example.com");
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'userpassword'));
            $user->setLastname("Lastname$i");
            $user->setFirstname("Firstname$i");
            $user->setBirthdate(new \DateTime('01-01-2002'));
            $user->setPhone("12345678$i");
            $user->setGender('Male');
            $user->setAddress("123 User Street $i");
            $user->setCity("UserCity$i");
            $user->setCountry("UserLand$i");
            $user->setCreatedAt(new \DateTime());
            $user->setUpdatedAt(new \DateTime());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
