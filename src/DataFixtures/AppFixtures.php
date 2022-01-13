<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Tag;
use App\Factory\NoteFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*
        $note = new Note();
        $note->setTitle('this is test note');
        $note->setNote('This is somme data to fill the note with some irrelevant stuff.');
        $manager->persist($note);

        $tag = new Tag();
        $tag->setName('brillant');
        $manager->persist($tag);
        */

        TagFactory::new()->createMany(5);
        NoteFactory::new()
            ->many(10)
            ->create( function() {
                return ['tags' => TagFactory::randomRange(0,3)];
            }
        );


        $manager->flush();
    }
}
