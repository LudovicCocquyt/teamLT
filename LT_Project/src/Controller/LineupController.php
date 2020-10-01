<?php

namespace App\Controller;

use App\Entity\Lineup;
use App\Form\LineupType;
use App\Repository\LineupRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lineup")
 */
class LineupController extends AbstractController
{
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
        $form = $this->createForm(LineupType::class, $lineup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lineup->setCreatedAt(new \DateTime('now'));
            $lineup->setCreatedby('admin');
            $lineup->setUpdatedAt(new \DateTime('now'));
            $lineup->setUpdatedby('ludo');

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

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lineup_index');
        }

        return $this->render('lineup/edit.html.twig', [
            'lineup' => $lineup,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lineup_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lineup $lineup): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineup->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lineup);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lineup_index');
    }

        /**
     * @Route("/{id}/showLineUp", name="lineups_show", methods={"GET"})
     */
    public function showLineUp(Lineup $lineup, UsersRepository $userRepo): Response
    {
        return $this->render('lineup/showLineUp.html.twig', [
            'lineup' => $lineup,
            // 'user'   =>$userRepo->findAll()
        ]);
    }
}
