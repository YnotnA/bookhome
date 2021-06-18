<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setEmail('admin@bookhome.com')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
        ;

        $user->setPassword($this->passwordHasher->hashPassword($user, 'admin'));
        
        $manager->persist($user);
        $manager->flush();
    }
}
