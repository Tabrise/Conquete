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
use App\Entity\Audit;
use App\Entity\AuditResponse;
use App\Form\AuditType;
use App\Repository\AuditResponseRepository;
use App\Repository\ThemeRepository;
use App\Repository\QuestionRepository;

#[Route('/societe')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'app_societe')]
    public function index(SocieteRepository $sr, ContactRepository $cr, #[CurrentUser] User $user): Response
    {
        if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true))
            $sr = $sr->findAll();
        else
            $sr = $sr->findBy(['idUser' => $user->getId()]);

        return $this->render('societe/index.html.twig', [
            'societes' => $sr,
            'contacts' => $cr->findAll()
        ]);
    }
    #[Route('/ajout', name: 'app_ajout_societe')]
    public function create(Request $request, EntityManagerInterface $em, #[CurrentUser] User $user): Response
    {
        $c = new Societe();
        $form = $this->createForm(SocieteType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $c->setIdUser($user);
            $em->persist($c);
            $em->flush();
            return $this->redirectToRoute('app_ajout_contact', ['s' => $c], Response::HTTP_SEE_OTHER);
        }
        return $this->render('societe/_form.html.twig', [
            'form' => $form
        ]);
    }
    #[Route('/{c}/modifier', name: 'app_modifier_societe')]
    public function edit(Request $request, Societe $c, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SocieteType::class, $c);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($c);
            $em->flush();
            $this->addFlash('Réussit', "Le Societe a été modifié");

            return $this->redirectToRoute('app_societe', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('societe/_form.html.twig', [
            'form' => $form
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

    #[Route('/page2/{s}', name: 'app_page')]
    public function page(Societe $s, SocieteRepository $sr, ContactRepository $cr, Request $request, SocieteRepository $societeRepository, ThemeRepository $themeRepository, QuestionRepository $questionRepository, AuditResponseRepository $arr, EntityManagerInterface $entityManager)
    {
        $s = $sr->find($s->getId());
        $c = $cr->findBy(['idSociete' => $s->getId()]);

        if (!$s) {
            throw $this->createNotFoundException('Société non trouvée');
        }
        $audit = $entityManager->getRepository(Audit::class)->findOneBy(['client' => $s]);

        if (!$audit) {
            $audit = new Audit();
            $audit->setClient($s);
        }

        $form = $this->createForm(AuditType::class, $audit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->all() as $child) {
                if (strpos($child->getName(), 'response_') === 0) {
                    $questionId = str_replace('response_', '', $child->getName());
                    $question = $questionRepository->find($questionId);
                    if ($question) {
                        $response = new AuditResponse();
                        $response->setQuestion($question);
                        $response->setResponse($child->getData());
                        $oldResponse = $arr->findBy(['audit' => $audit]);
                        foreach ($oldResponse as $old) {
                            $audit->removeAuditResponse($old);
                        }
                        $audit->addAuditResponse($response);
                    }
                }
            }

            $entityManager->persist($audit);
            $entityManager->flush();

            return $this->redirectToRoute('app_societe', [], Response::HTTP_SEE_OTHER);
        }

        $themes = $themeRepository->findBy(['utiliser' => true], ['ordre' => 'ASC']);
        $questions = $questionRepository->findBy(['utiliser' => true], ['ordre' => 'ASC']);

        return $this->render('prospect.html.twig', [
            'prospect' => $s,
            'contacts' => $c,
            'audit' => $audit,
            'form' => $form->createView(),
            'themes' => $themes,
            'questions' => $questions,
        ]);
    }
}
