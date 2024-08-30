<?php

namespace App\Controller;


use App\Entity\Societe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SocieteType;

use App\Repository\ContactRepository;
use App\Repository\SocieteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


#[Route('/societe')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'app_societe')]
    public function index(SocieteRepository $sr, #[CurrentUser] User $user): Response
    {
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true))
            $sr = $sr->findAll();
        else
            $sr = $sr->findBy(['idUser' => $user->getId()]);

        return $this->render('societe/index.html.twig', [
            'societes' => $sr,

        ]);
    }
    #[Route('/ajout', name: 'app_ajout_societe')]
     public function create(Request $request, EntityManagerInterface $em, #[CurrentUser] User $user): Response
    {
        $s = new Societe();
        $form = $this->createForm(SocieteType::class, $s);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $s->setIdUser($user);
            $em->persist($s);
            $em->flush();
            return $this->redirectToRoute('app_page', [
                's' => $s,
                'contact' => $s->getContacts()[0],
            ]);
        }
        return $this->render('societe/_add.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{s}/modifier', name: 'app_modifier_societe')]
    public function edit(Request $request, Societe $s, EntityManagerInterface $em): Response
    {
        

        $form = $this->createForm(SocieteType::class, $s);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($s);
            $em->flush();
            $this->addFlash('Réussit', "Le Prospect a été modifié");

            return $this->redirectToRoute('app_page', ['s' => $s], Response::HTTP_SEE_OTHER);
        }

        return $this->render('util/_modal.html.twig', [
            'form' => $form,
            'action' => 'Modification',
            'entite' => $s,
            'twig' => 'societe/_update.html.twig',
            'id' => $s->getSiret()
        ]);
    }
    #[Route('/{s}/suprimer', name: 'app_suprimer_societe')]
    public function delete(Societe $s, EntityManagerInterface $em, SocieteRepository $sr, ContactRepository $cr)
    {
        $c = $cr->findAll();
        foreach ($c as $contact) {
            if ($contact->getIdSociete() == $s) {
                $em->remove($contact);
                $em->flush();
            }
        }
        $s = $sr->find($s->getId());
        $em->remove($s);
        $em->flush();
        $this->addFlash('Réussit', "La Societe a été supprimer");
        return $this->redirectToRoute('app_societe', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/info/{s}', name: 'app_page')]
    public function page(Societe $s, SocieteRepository $sr, ContactRepository $cr,)
    {
        $s = $sr->find($s->getId());
        $c = $cr->findOneBy(['idSociete' => $s->getId()]);

        if($s->getIdUser() !=  $this->getUser() && !in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true))
            return $this->redirectToRoute('app_societe');

        return $this->render('prospect.html.twig', [
            'prospect' => $s,
            'contact' => $c,
        ]);
    }
}
