<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use App\Repository\JeuxRepository;
use App\Repository\NewsRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function home(ContentStaticRepository $ContentStaticRepo,NewsRepository $newsRepo, JeuxRepository $jeuxRepo)
    {

    	return $this->render('homePage.html.twig', [
            'jeux'    => $jeuxRepo->findAll(),
            'news'    => $newsRepo->findAll(),
            'statics' => $ContentStaticRepo->findAll()
        ]);
	}
}
