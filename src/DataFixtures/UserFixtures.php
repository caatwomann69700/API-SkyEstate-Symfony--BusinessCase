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
        // Admin
        $admin = new User();
        $admin->setFirstname('Admin')
            ->setLastname('Admin')
            ->setEmail('admin@example.com')
            ->setBirthdate(new \DateTime('1980-01-01'))
            ->setPhone('0600000000')
            ->setCountry('France')
            ->setCity('Paris')
            ->setGender('Male')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordHasher->hashPassword($admin, 'password123'));
        $manager->persist($admin);

        // Locataire
        $locataire = new User();
        $locataire->setFirstname('Locataire')
            ->setLastname('Locataire')
            ->setEmail('locataire@example.com')
            ->setBirthdate(new \DateTime('1990-02-15'))
            ->setPhone('0601111111')
            ->setCountry('France')
            ->setCity('Lyon')
            ->setGender('Female')
            ->setRoles(['ROLE_LOCATAIRE'])
            ->setPassword($this->passwordHasher->hashPassword($locataire, 'password123'));
        $manager->persist($locataire);

        // Propriétaire
        $proprietaire = new User();
        $proprietaire->setFirstname('Propriétaire')
            ->setLastname('Propriétaire')
            ->setEmail('proprietaire@example.com')
            ->setBirthdate(new \DateTime('1985-03-20'))
            ->setPhone('0602222222')
            ->setCountry('France')
            ->setCity('Marseille')
            ->setGender('Other')
            ->setRoles(['ROLE_PROPRIETAIRE'])
            ->setPassword($this->passwordHasher->hashPassword($proprietaire, 'password123'));
        $manager->persist($proprietaire);

        $manager->flush();
    }
}
