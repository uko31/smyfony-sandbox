<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Factory\AccountFactory;
use App\Factory\NoteFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $michaelis = new Account();
        $michaelis->setUsername('michaelis');
        $michaelis->setPassword($this->passwordHasher->hashPassword(
            $michaelis,
            'test'
        ));
        $manager->persist($michaelis);

        AccountFactory::new()->createMany(5);
        TagFactory::new()->createMany(5);
        NoteFactory::new()
            ->createMany(10, function() {
                return [
                    'author' => AccountFactory::random(),
                    'tags' => TagFactory::randomRange(0,3),
                ];
            });

        $manager->flush();
    }
}
