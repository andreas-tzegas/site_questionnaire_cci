<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private \Faker\Generator $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        // Create admin user
        $admin = new User();
        $admin->setFirstName('Pierre');
        $admin->setLastName('Bertrand');
        $admin->setEmail('admin@test.com');
        $admin->setRoles(['ROLE_ADMIN']);

        // Hash password
        $password = $this->passwordEncoder->encodePassword($admin, 'Test1234!');
        $admin->setPassword($password);

        $manager->persist($admin);

        $manager->flush();
    }
}
