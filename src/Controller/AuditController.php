<?php

namespace App\Controller;

use App\Entity\Audit;
use App\Entity\AuditResponse;
use App\Form\AuditType;
use App\Repository\AuditResponseRepository;
use App\Repository\SocieteRepository;
use App\Repository\ThemeRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audit')]
class AuditController extends AbstractController
{
    #[Route('/new/{societeId}', name: 'app_audit_new', methods: ['GET', 'POST'])]
    public function new(int $societeId, Request $request, SocieteRepository $societeRepository, ThemeRepository $themeRepository, QuestionRepository $questionRepository, AuditResponseRepository $arr, EntityManagerInterface $entityManager): Response
    {
        $societe = $societeRepository->find($societeId);
        if (!$societe) {
            throw $this->createNotFoundException('Société non trouvée');
        }
        $audit = $entityManager->getRepository(Audit::class)->findOneBy(['client' => $societe]);

        if (!$audit){
            $audit = new Audit();
            $audit->setClient($societe);
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

        return $this->render('audit/new.html.twig', [
            'audit' => $audit,
            'form' => $form->createView(),
            'themes' => $themes,
            'questions' => $questions,
            'societe' => $societe
        ]);
    }
}
