<?php

namespace App\Controller;

use App\Entity\Palmares;
use App\Form\PalmaresType;
use App\Repository\PalmaresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/palmares")
 */
class PalmaresController extends AbstractController
{
    /**
     * @Route("/", name="palmares_index", methods={"GET"})
     */
    public function index(PalmaresRepository $palmaresRepository): Response
    {
        return $this->render('palmares/index.html.twig', [
            'palmares' => $palmaresRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="palmares_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $palmare = new Palmares();
        $form = $this->createForm(PalmaresType::class, $palmare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $palmare->setCreatedAt(new \DateTime('now'));
            $palmare->setCreatedby('admin');
            $palmare->setUpdatedAt(new \DateTime('now'));
            $palmare->setUpdatedby('ludo');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($palmare);
            $entityManager->flush();

            return $this->redirectToRoute('palmares_index');
        }

        return $this->render('palmares/new.html.twig', [
            'palmare' => $palmare,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="palmares_show", methods={"GET"})
     */
    public function show(Palmares $palmare): Response
    {
        return $this->render('palmares/show.html.twig', [
            'palmare' => $palmare,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="palmares_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Palmares $palmare): Response
    {
        $form = $this->createForm(PalmaresType::class, $palmare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $palmare->setUpdatedAt(new \DateTime('now'));
            $palmare->setUpdatedby('admin');
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('palmares_index');
        }

        return $this->render('palmares/edit.html.twig', [
            'palmare' => $palmare,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="palmares_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Palmares $palmare): Response
    {
        if ($this->isCsrfTokenValid('delete'.$palmare->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($palmare);
            $entityManager->flush();
        }

        return $this->redirectToRoute('palmares_index');
    }
}
