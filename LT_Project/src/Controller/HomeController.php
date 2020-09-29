<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index_page")
     */
    public function home(ContentStaticRepository $ContentStaticRepo)
    {

    	return $this->render('homePage.html.twig', [
            'statics' => $ContentStaticRepo->findAll()
        ]);
	}
}
