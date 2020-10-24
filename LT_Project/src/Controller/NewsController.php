<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use App\Repository\ImagesRepository;
use App\Repository\NewsRepository;
use App\Form\NewsType;
use App\Entity\Images;
use App\Entity\News;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    private $imageRepo;

    public function __construct(ImagesRepository $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    /**
     * @Route("/", name="news_index", methods={"GET"})
     */
    public function index(NewsRepository $newsRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('news/index.html.twig', [
            'news' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $news->setCreatedAt(new \DateTime('now'));
            $news->setCreatedby('admin');
            $news->setUpdatedAt(new \DateTime('now'));
            $news->setUpdatedby('ludo');

            if (!is_null($form->get('images')->getData())) {
                // On récupère l'image transmise
                $image = $form->get('images')->getData();
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setName($fichier);
                $news->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/new.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('news/show.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, News $news): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $news->setUpdatedAt(new \DateTime('now'));
            $news->setUpdatedby('admin');

            //Gestion de l'image
            if ($form->get('images')->getData()) {

                if (!empty($this->imageRepo->findBy(array('news' => $news)))) {
                    //si il y a une image, on supprime l'image

                    $lastImage = $this->imageRepo->findBy(array('news' => $news))[0];
                    // On récupère le nom de l'image
                    $nom = $lastImage->getName();
                    // On supprime le fichier
                    unlink($this->getParameter('images_directory').'/'.$nom);

                    // On supprime l'entrée de la base
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($lastImage);
                    $em->flush();

                }

                // On récupère l'image transmise
                $image = $form->get('images')->getData();
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                // On copie le fichier dans le dossier image
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $img = new Images();
                $img->setName($fichier);
                $news->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_index');
        }

        return $this->render('news/edit.html.twig', [
            'news' => $news,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(Request $request, News $news): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$news->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();

            if ($this->imageRepo->findBy(array('news' => $news))) {

                $image = $this->imageRepo->findBy(array('news' => $news))[0];
                // On récupère le nom de l'image
                $nom = $image->getName();
                // On supprime le fichier
                unlink($this->getParameter('images_directory').'/'.$nom);
            
                $entityManager->remove($image);
            }

            $entityManager->remove($news);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_index');
    }

    /**
     * @Route("/{id}/showNews", name="showNews_show", methods={"GET"})
     */
    public function showNews(News $news, ContentStaticRepository $ContentStaticRepo): Response
    {
        $image = (!empty($this->imageRepo->findBy(array('news' => $news)))) ? $this->imageRepo->findBy(array('news' => $news))[0]->getName() : '' ;
        return $this->render('news/showNews.html.twig', [
            'news'      => $news,
            'statics'   => $ContentStaticRepo->findAll(),
            'imageName' => $image
        ]);
    }
}
