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
        $arrayNewsActive = $newsRepo->findBy(array('isActive' => true));
        $lastNewsId      = end($arrayNewsActive)->getId();

    	return $this->render('homePage.html.twig', [
            'statics'   => $contentStaticRepo->findAll(),
            'news'      => $newsRepo->findBy(array('isActive' => true)),
            'imageNews' => $imageRepo->findBy(array('news' => $lastNewsId))[0]->getName(),
            'palmares'  => $palmaresRepo->findAll(),
            'resultats' => $resultatsRepo->findAll(),
            'jeux'      => $jeuxRepo->findBy(array('isActive' => true))
        ]);
	}
}
