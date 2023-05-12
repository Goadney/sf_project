<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    // en php 8 on peut creer une propriété direct dans le construct
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = (new User())
            ->setFirstName('greg')
            ->setLastName('greg')
            ->setEmail('greg@greg.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordHasher->hashPassword(new User(), 'greg1234')
            );

        $manager->persist($user);
        // pour faire une file d'attente, on dit a doctrine que cette objet est pret a etre envoyé en bdd comme un commit
        $manager->flush();
        // le flush envoi tout les objets persist

        //symfony console doctrine:fixtures:load
    }
}
