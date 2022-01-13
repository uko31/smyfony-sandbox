<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $note = new Note();
        $note->setTitle('this is test note');
        $note->setNote('This is somme data to fill the note with some irrelevant stuff.');
        $manager->persist($note);

        $tag = new Tag();
        $tag->setName('brillant');
        $manager->persist($tag);


        $manager->flush();
    }
}
