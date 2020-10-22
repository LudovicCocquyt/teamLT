<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Jeux;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    // 	$user  = new Users;
    // 	$jeux1 = new Jeux;
    // 	$jeux2 = new Jeux;
    // 	$jeux3 = new Jeux;
    // 	$jeux4 = new Jeux;

    // 	$jeux1->setIsActif(true)
    // 		->setName('Call Of Duty')
    // 		->setImage('12313232')
    // 		->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est labo')
    // 	$jeux2->setIsActif(true)
    // 		->setName('Call Of Duty')
    // 		->setImage('12313232')
    // 		->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est labo')
    // 	$jeux3->setIsActif(true)
    // 		->setName('Call Of Duty')
    // 		->setImage('12313232')
    // 		->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est labo')
    // 	$jeux4->setIsActif(true)
    // 		->setName('Call Of Duty')
    // 		->setImage('12313232')
    // 		->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est labo')


    //     for ($i=1; $i < 15 ; $i++) {
	   //      $user->setemail('aa@' . $i .'fr')
	   //           ->setPassword($this->encoder->encodePassword($user, 'aa'))
	   //           ->setPseudo('Player' . $i)
	   //           ->setIsActif(true)
	   //           ->setFirstname('Nom' . $i)
	   //           ->setLastname('Prénom' . $i)
	   //           ->setUsername('PseuDo' . $i)
	   //           ->setJeux('jeux' $i)
	   //           ->setIsActive(true)
	   //           ->setNationality('fr.png')
	   //           ->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodoconsequat. Duis aute irure dolor in reprehenderit in voluptate velit essecillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est labo');

	   //      $manager->persist($user);
    //     }

    //     $manager->flush();

    }
}
