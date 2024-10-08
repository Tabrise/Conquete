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
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact/{s}', name: 'app_contact')]
    public function index(Societe $s,ContactRepository $cr): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $cr->findBy(['idSociete' => $s->getId()]),
            'nomSociete' => $s->getNom(),
            'prospect'=> $s
        ]);
    }

    #[Route('/contact/ajout/{s}', name: 'app_ajout_contact')]
    public function create(Request $request, EntityManagerInterface $em, Societe $s)
    {
        $newC = new Contact();
        $form = $this->createForm(ContactType::class, $newC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newC->setIdSociete($s);
            $em->persist($newC);
            $em->flush();
            $this->addFlash('Réussit', "Le contact a été ajouté");
            return $this->redirectToRoute('app_page',[
                's'=>$s,
            ]);
        }
        
        return $this->render('util/_modal.html.twig', [
            'action'=>'Ajout',
            'entite'=> $s,
            'id'=> $s->getId(),
            'form' => $form,
            'twig'=> 'contact/_add.html.twig'
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

            return $this->redirectToRoute('app_page', ['s'=>$c->getIdSociete()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('util/_modal.html.twig', [
            'action'=>'Modification',
            'entite'=> $c,
            'id'=> $c->getId(),
            'form' => $form,
            'twig'=> 'contact/_update.html.twig'
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
