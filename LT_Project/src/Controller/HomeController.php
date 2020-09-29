<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use App\Repository\NewsRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function home(ContentStaticRepository $ContentStaticRepo,NewsRepository $newsRepo)
    {

    	return $this->render('homePage.html.twig', [
			'news'    => $newsRepo->findAll(),
			'statics' => $ContentStaticRepo->findAll()
        ]);
	}
}
