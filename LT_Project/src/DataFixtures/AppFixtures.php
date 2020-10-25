<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ContentStatic;
use App\Entity\Users;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $entityManager)
    {
        $user = new Users;

        $user->setCreatedAt(new \DateTime('now'));
        $user->setCreatedby('Dieu');
        $user->setUpdatedAt(new \DateTime('now'));
        $user->setUpdatedby('Dieu');
        $user->setIsActive(true);
        $user->setEmail('admin@admin.com');
        $user->setPassword(
                $this->encoder->encodePassword($user,'admin'));
        $user->setNationality('eu.png');
        $user->setBirthday(new \Datetime);
        $user->setDescription('admin');
        $user->setUsername('admin');
        $user->setRoles(['ROLE_ADMIN']);

        $entityManager->persist($user);

        $cs1  = new ContentStatic;
        $cs2  = new ContentStatic;
        $cs3  = new ContentStatic;
        $cs4  = new ContentStatic;
        $cs5  = new ContentStatic;
        $cs6  = new ContentStatic;
        $cs7  = new ContentStatic;
        $cs8  = new ContentStatic;
        $cs9  = new ContentStatic;
        $cs10 = new ContentStatic;
        $cs11 = new ContentStatic;

        $cs1->setCreatedAt(new \DateTime('now'));
        $cs1->setCreatedby('DataFixtures');
        $cs1->setUpdatedAt(new \DateTime('now'));
        $cs1->setUpdatedby('DataFixtures');
        $cs1->setTitle('Activer le formulaire de Contact ?');
        $cs1->setContact(true);
        $entityManager->persist($cs1);

        $cs2->setCreatedAt(new \DateTime('now'));
        $cs2->setCreatedby('DataFixtures');
        $cs2->setUpdatedAt(new \DateTime('now'));
        $cs2->setUpdatedby('DataFixtures');
        $cs2->setTitle('Grand titre');
        $cs2->setDescription('Mon Site Web');
        $entityManager->persist($cs2);

        $cs3->setCreatedAt(new \DateTime('now'));
        $cs3->setCreatedby('DataFixtures');
        $cs3->setUpdatedAt(new \DateTime('now'));
        $cs3->setUpdatedby('DataFixtures');
        $cs3->setTitle('Bio');
        $cs3->setDescription('La description de mon super site...');
        $entityManager->persist($cs3);

        $cs4->setCreatedAt(new \DateTime('now'));
        $cs4->setCreatedby('DataFixtures');
        $cs4->setUpdatedAt(new \DateTime('now'));
        $cs4->setUpdatedby('DataFixtures');
        $cs4->setTitle('Second titre');
        $cs4->setDescription('WebSite');
        $entityManager->persist($cs4);

        $cs5->setCreatedAt(new \DateTime('now'));
        $cs5->setCreatedby('DataFixtures');
        $cs5->setUpdatedAt(new \DateTime('now'));
        $cs5->setUpdatedby('DataFixtures');
        $cs5->setTitle('Steam');
        $cs5->setDescription('#');
        $entityManager->persist($cs5);

        $cs6->setCreatedAt(new \DateTime('now'));
        $cs6->setCreatedby('DataFixtures');
        $cs6->setUpdatedAt(new \DateTime('now'));
        $cs6->setUpdatedby('DataFixtures');
        $cs6->setTitle('Discord');
        $cs6->setDescription('#');
        $entityManager->persist($cs6);

        $cs7->setCreatedAt(new \DateTime('now'));
        $cs7->setCreatedby('DataFixtures');
        $cs7->setUpdatedAt(new \DateTime('now'));
        $cs7->setUpdatedby('DataFixtures');
        $cs7->setTitle('Battle Net');
        $cs7->setDescription('#');
        $entityManager->persist($cs7);

        $cs8->setCreatedAt(new \DateTime('now'));
        $cs8->setCreatedby('DataFixtures');
        $cs8->setUpdatedAt(new \DateTime('now'));
        $cs8->setUpdatedby('DataFixtures');
        $cs8->setTitle('Facebook');
        $cs8->setDescription('#');
        $entityManager->persist($cs8);

        $cs9->setCreatedAt(new \DateTime('now'));
        $cs9->setCreatedby('DataFixtures');
        $cs9->setUpdatedAt(new \DateTime('now'));
        $cs9->setUpdatedby('DataFixtures');
        $cs9->setTitle('Twitter');
        $cs9->setDescription('#');
        $entityManager->persist($cs9);

        $cs10->setCreatedAt(new \DateTime('now'));
        $cs10->setCreatedby('DataFixtures');
        $cs10->setUpdatedAt(new \DateTime('now'));
        $cs10->setUpdatedby('DataFixtures');
        $cs10->setTitle('Youtube');
        $cs10->setDescription('#');
        $entityManager->persist($cs10);

        $cs11->setCreatedAt(new \DateTime('now'));
        $cs11->setCreatedby('DataFixtures');
        $cs11->setUpdatedAt(new \DateTime('now'));
        $cs11->setUpdatedby('DataFixtures');
        $cs11->setTitle('Twitch');
        $cs11->setDescription('#');
        $entityManager->persist($cs11);


        $entityManager->flush();
    }
}
