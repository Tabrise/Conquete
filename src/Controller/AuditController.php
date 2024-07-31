<?php

namespace App\Controller;

use App\Entity\Audit;
use App\Entity\Societe;
use App\Entity\AuditResponse;
use App\Form\AuditType;
use App\Repository\AuditResponseRepository;
use App\Repository\ThemeRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/audit')]
class AuditController extends AbstractController
{
    #[Route('/{s}', name: 'app_audit')]
    public function audit(Societe $s, Request $request, ThemeRepository $themeRepository, QuestionRepository $questionRepository, AuditResponseRepository $arr, EntityManagerInterface $em)
    {
        $audit = $em->getRepository(Audit::class)->findOneBy(['client' => $s]);

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
                            $em->remove($old);
                        }
                        $audit->addAuditResponse($response);
                    }
                }
            }
            $em->persist($audit);
            $em->flush();

            return $this->redirectToRoute('app_page', [
                's' => $s,
            ]);
        }

        $themes = $themeRepository->findBy(['utiliser' => true], ['ordre' => 'ASC']);
        $questions = $questionRepository->findBy(['utiliser' => true], ['ordre' => 'ASC']);

        return $this->render('audit/new.html.twig', [
            'audit' => $audit,
            'form' => $form->createView(),
            'themes' => $themes,
            'questions' => $questions,
            'prospect' => $s
        ]);
    }
}
