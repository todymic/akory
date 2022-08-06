<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class UserFixture extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    protected $passwordEncoder;

    /**
     * UserFixture constructor.
     */
    public function __construct(?UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    abstract public function load(ObjectManager $manager);
}
