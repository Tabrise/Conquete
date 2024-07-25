<?php

namespace App\Controller;

use App\Entity\EtatSociete;
use App\Form\EtatSocieteType;
use App\Repository\EtatSocieteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etat/societe')]
class EtatSocieteController extends AbstractController
{
    #[Route('/', name: 'app_etat_societe_index', methods: ['GET'])]
    public function index(EtatSocieteRepository $etatSocieteRepository): Response
    {
        return $this->render('etat_societe/index.html.twig', [
            'etat_societes' => $etatSocieteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_etat_societe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etatSociete = new EtatSociete();
        $form = $this->createForm(EtatSocieteType::class, $etatSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etatSociete);
            $entityManager->flush();

            return $this->redirectToRoute('app_etat_societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etat_societe/new.html.twig', [
            'etat_societe' => $etatSociete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_societe_show', methods: ['GET'])]
    public function show(EtatSociete $etatSociete): Response
    {
        return $this->render('etat_societe/show.html.twig', [
            'etat_societe' => $etatSociete,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etat_societe_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtatSociete $etatSociete, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtatSocieteType::class, $etatSociete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etat_societe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etat_societe/edit.html.twig', [
            'etat_societe' => $etatSociete,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_societe_delete', methods: ['POST'])]
    public function delete(Request $request, EtatSociete $etatSociete, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etatSociete->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etatSociete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etat_societe_index', [], Response::HTTP_SEE_OTHER);
    }
}
