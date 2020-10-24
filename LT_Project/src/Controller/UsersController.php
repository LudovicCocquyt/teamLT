<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ContentStaticRepository;
use App\Repository\ImagesRepository;
use App\Repository\UsersRepository;
use App\Form\UsersEditType;
use App\Form\UsersType;
use App\Entity\Images;
use App\Entity\Users;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    private $encoder;

    private $imageRepo;

    public function __construct(UserPasswordEncoderInterface $encoder, ImagesRepository $imageRepo)
    {
        $this->encoder   = $encoder;
        $this->imageRepo = $imageRepo;
    }
    /**
     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(UsersRepository $usersRepository): Response
    { 
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                ));

            $user->setCreatedAt(new \DateTime('now'));
            $user->setCreatedby('admin');
            $user->setUpdatedAt(new \DateTime('now'));
            $user->setUpdatedby('admin');
            $user->setIsActive(true);
            
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
                $user->addImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/{id}", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("profile/{id}/edit", name="users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user, ImagesRepository $imageRepo = null): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UsersEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Gestion de l'image
            if ($form->get('images')->getData()) {

                if (!empty($imageRepo->findBy(array('users' => $user)))) {
                    //si il y a une image, on supprime l'image

                    $lastImage = $imageRepo->findBy(array('users' => $user))[0];
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
                $user->addImage($img);
            }

            $user->setUpdatedAt(new \DateTime('now'));
            $user->setUpdatedby('admin');

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index');
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $data  = json_decode($request->getContent(), true);
            
            if ($this->imageRepo->findBy(array('users' => $user))) {

                $image = $this->imageRepo->findBy(array('users' => $user))[0];
                // On récupère le nom de l'image
                $nom = $image->getName();
                // On supprime le fichier
                unlink($this->getParameter('images_directory').'/'.$nom);
            
                $entityManager->remove($image);
            }

            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * @Route("/{id}/showUser", name="user_show", methods={"GET"})
     */
    public function showUser(Users $user, ContentStaticRepository $contentStaticRepo): Response
    {
        $image = (!empty($this->imageRepo->findBy(array('users' => $user)))) ? $this->imageRepo->findBy(array('users' => $user))[0]->getName() : '' ;

        return $this->render('users/showUser.html.twig', [
            'user'      => $user,
            'statics'   => $contentStaticRepo->findAll(),
            'imageName' => $image,
            'birthday'  => $this->birthday($user->getBirthday()->format('d/m/Y'))
        ]);
    }

    private function birthday($birthday) 
    { 
        $am = explode('/', $birthday);
        $an = explode('/', date('d/m/Y'));
        if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0]))) return $an[2] - $am[2];
        return $an[2] - $am[2] - 1; 
    } 
}
