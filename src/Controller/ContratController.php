<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContratController extends AbstractController
{
    #[Route('/contrat', name: 'app_contrat')]
    public function index(): Response
    {
        return $this->render('contrat/index.html.twig', [
            
        ]);
    }
    #[Route('/contrat/ajout', name: 'app_ajout_contrat')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {
        $c = new Contrat();
        $form = $this->createForm(ContratType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($c);
            $em->flush();
            $this->addFlash('Réussit',"Le contrat a été ajouté");

            return $this->render('contrat/index.html.twig', [
                'prestation'=> $form->getData()->getIdPrestation(),
            ], );
        }
        return $this->render('contrat/newContrat.html.twig', [
            'form'=>$form
        ]);
    }
}
