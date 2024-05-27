<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Entity\Societe;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\SocieteRepository;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $cr, SocieteRepository $sr): Response
    {
        $sr = $sr->findAll();

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contacts' => $cr->findAll(),
            'nomSociete' => $sr
        ]);
    }
    #[Route('/contact/ajout/{s}', name: 'app_ajout_contact')]
    public function create(Request $request, EntityManagerInterface $em, Societe $s): Response
    {
        $c = new Contact();
        $form = $this->createForm(ContactType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $c->setIdSociete($s);
            $em->persist($c);
            $em->flush();
            $this->addFlash('Réussit', "Le contact a été ajouté");

            return $this->redirectToRoute('app_societe', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('_form.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/contact/{c}/modifier', name: 'app_modifier_contact')]
    public function edit(Request $request, Contact $c, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ContactType::class, $c);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($c);
            $em->flush();
            $this->addFlash('Réussit', "Le contact a été modifié");

            return $this->redirectToRoute('app_societe', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('_form.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/contact/{c}/suprimer', name: 'app_suprimer_contact')]
    public function delete(ContactRepository $cr, Contact $c, EntityManagerInterface $em)
    {
        $c = $cr->find($c->getId());
        $em->remove($c);
        $em->flush();
        $this->addFlash('Réussit', "Le Contact a été supprimer");
        return $this->redirectToRoute("app_contact", [], Response::HTTP_SEE_OTHER);
    }
}
