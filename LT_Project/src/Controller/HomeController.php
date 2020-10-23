<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use App\Repository\ResultatsRepository;
use App\Repository\PalmaresRepository;
use App\Repository\ImagesRepository;
use App\Repository\JeuxRepository;
use App\Repository\NewsRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function home(ContentStaticRepository $contentStaticRepo,NewsRepository $newsRepo, JeuxRepository $jeuxRepo, PalmaresRepository $palmaresRepo, ResultatsRepository $resultatsRepo, ImagesRepository $imageRepo)
    {
        $idLastNews = $newsRepo->findBy(array(),array('id' => 'DESC'))[0]->getId();

    	return $this->render('homePage.html.twig', [
            'jeux'      => $jeuxRepo->findBy(array('isActive' => true)),
            'news'      => $newsRepo->findAll(),
            'statics'   => $contentStaticRepo->findAll(),
            'resultats' => $resultatsRepo->findAll(),
            'palmares'  => $palmaresRepo->findAll(),
            'imageNews' => $imageRepo->findBy( array('news' => $idLastNews))[0]->getName()
        ]);
	}
}
