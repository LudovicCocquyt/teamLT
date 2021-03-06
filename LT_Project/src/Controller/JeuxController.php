<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Images;
use App\Form\JeuxType;
use App\Repository\JeuxRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jeux")
 */
class JeuxController extends AbstractController
{
    private $imageRepo;

    public function __construct(ImagesRepository $imageRepo = null)
    {
        $this->imageRepo = $imageRepo;
    }

    /**
     * @Route("/", name="jeux_index", methods={"GET"})
     */
    public function index(JeuxRepository $jeuxRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('jeux/index.html.twig', [
            'jeuxes' => $jeuxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="jeux_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $jeux = new Jeux();
        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jeux->setCreatedAt(new \DateTime('now'));
            $jeux->setCreatedby($this->getUser()->getUserName());
            $jeux->setUpdatedAt(new \DateTime('now'));
            $jeux->setUpdatedby($this->getUser()->getUserName());
            $jeux->setDescription(nl2br($_POST['jeux']['description']));

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
                $jeux->setImageName($fichier);


                $jeux->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jeux);
            $entityManager->flush();

            return $this->redirectToRoute('jeux_index');
        }

        return $this->render('jeux/new.html.twig', [
            'jeux' => $jeux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_show", methods={"GET"})
     */
    public function show(Jeux $jeux): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('jeux/show.html.twig', [
            'jeux' => $jeux,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jeux_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jeux $jeux): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(JeuxType::class, $jeux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $jeux->setUpdatedAt(new \DateTime('now'));
            $jeux->setUpdatedby($this->getUser()->getUserName());
            $jeux->setDescription(nl2br($_POST['jeux']['description']));

            //Gestion de l'image
            if ($form->get('images')->getData()) {

                if (!empty($this->imageRepo->findBy(array('jeux' => $jeux)))) {
                    //si il y a une image, on supprime l'image

                    $lastImage = $this->imageRepo->findBy(array('jeux' => $jeux))[0];
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
                $jeux->setImageName($fichier);
                $jeux->addImage($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jeux_index');
        }

        return $this->render('jeux/edit.html.twig', [
            'jeux' => $jeux,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jeux_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Jeux $jeux): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$jeux->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            if ($this->imageRepo->findBy(array('jeux' => $jeux))) {

                $image = $this->imageRepo->findBy(array('jeux' => $jeux))[0];
                // On récupère le nom de l'image
                $nom = $image->getName();
                // On supprime le fichier
                unlink($this->getParameter('images_directory').'/'.$nom);
            
                $entityManager->remove($image);
            }
            
            $entityManager->remove($jeux);
            $entityManager->flush();
        }

        return $this->redirectToRoute('jeux_index');
    }
}
