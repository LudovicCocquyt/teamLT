<?php

namespace App\Controller;

use App\Entity\ContentStatic;
use App\Form\ContentStaticType;
use App\Repository\ContentStaticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/content/static")
 */
class ContentStaticController extends AbstractController
{
    /**
     * @Route("/", name="content_static_index", methods={"GET"})
     */
    public function index(ContentStaticRepository $contentStaticRepository): Response
    {
        return $this->render('content_static/index.html.twig', [
            'content_statics' => $contentStaticRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="content_static_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $contentStatic = new ContentStatic();
        $form = $this->createForm(ContentStaticType::class, $contentStatic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contentStatic);
            $entityManager->flush();

            return $this->redirectToRoute('content_static_index');
        }

        return $this->render('content_static/new.html.twig', [
            'content_static' => $contentStatic,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="content_static_show", methods={"GET"})
    //  */
    // public function show(ContentStatic $contentStatic): Response
    // {
    //     return $this->render('content_static/show.html.twig', [
    //         'content_static' => $contentStatic,
    //     ]);
    // }

    /**
     * @Route("/{id}/edit", name="content_static_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ContentStatic $contentStatic): Response
    {
        $form = $this->createForm(ContentStaticType::class, $contentStatic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contentStatic->setUpdatedAt(new \DateTime('now'));
            $contentStatic->setUpdatedby('admin');

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('content_static_index');
        }

        return $this->render('content_static/edit.html.twig', [
            'content_static' => $contentStatic,
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * @Route("/{id}", name="content_static_delete", methods={"DELETE"})
    //  */
    // public function delete(Request $request, ContentStatic $contentStatic): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$contentStatic->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($contentStatic);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('content_static_index');
    // }
}
