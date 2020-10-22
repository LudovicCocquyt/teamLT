<?php

namespace App\Controller;

use App\Entity\Lineup;
use App\Entity\Images;
use App\Form\LineupType;
use App\Repository\ImagesRepository;
use App\Repository\LineupRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lineup")
 */
class LineupController extends AbstractController
{
    private $imageRepo;

    public function __construct(ImagesRepository $imageRepo)
    {
        $this->imageRepo = $imageRepo;
    }

    /**
     * @Route("/", name="lineup_index", methods={"GET"})
     */
    public function index(LineupRepository $lineupRepository): Response
    {
        return $this->render('lineup/index.html.twig', [
            'lineups' => $lineupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lineup_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lineup = new Lineup();
        $form   = $this->createForm(LineupType::class, $lineup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lineup->setCreatedAt(new \DateTime('now'));
            $lineup->setCreatedby('admin');
            $lineup->setUpdatedAt(new \DateTime('now'));
            $lineup->setUpdatedby('ludo');

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
                $lineup->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lineup);
            $entityManager->flush();

            return $this->redirectToRoute('lineup_index');
        }

        return $this->render('lineup/new.html.twig', [
            'lineup' => $lineup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lineup_show", methods={"GET"})
     */
    public function show(Lineup $lineup): Response
    {
        return $this->render('lineup/show.html.twig', [
            'lineup' => $lineup,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lineup_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lineup $lineup): Response
    {
        $form = $this->createForm(LineupType::class, $lineup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lineup->setUpdatedAt(new \DateTime('now'));
            $lineup->setUpdatedby('admin');

            //Gestion de l'image
            if ($form->get('images')->getData()) {

                if (!empty($this->imageRepo->findBy(array('lineup' => $lineup)))) {
                    //si il y a une image, on supprime l'image

                    $lastImage = $this->imageRepo->findBy(array('lineup' => $lineup))[0];
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
                $lineup->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lineup_index');
        }

        return $this->render('lineup/edit.html.twig', [
            'lineup' => $lineup,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lineup_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lineup $lineup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            if ($this->imageRepo->findBy(array('lineup' => $lineup))) {

                $image = $this->imageRepo->findBy(array('lineup' => $lineup))[0];
                // On récupère le nom de l'image
                $nom = $image->getName();
                // On supprime le fichier
                unlink($this->getParameter('images_directory').'/'.$nom);
            
                $entityManager->remove($image);
            }

            $entityManager->remove($lineup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lineup_index');
    }

        /**
     * @Route("/{id}/showLineUp", name="lineups_show", methods={"GET"})
     */
    public function showLineUp(Lineup $lineup, UsersRepository $userRepo, ContentStaticRepository $contentStaticRepo): Response
    {
        $image = (!empty($this->imageRepo->findBy(array('lineup' => $lineup)))) ? $this->imageRepo->findBy(array('lineup' => $lineup))[0]->getName() : '' ;

        return $this->render('lineup/showLineUp.html.twig', [
            'lineup'    => $lineup,
            'statics'   => $contentStaticRepo->findAll(),
            'imageName' => $image
        ]);
    }
}
