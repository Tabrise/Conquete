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
            $rep=$audit;
        } else
            $rep = $arr->findQuestionsByAuditId($audit->getId());

        $form = $this->createForm(AuditType::class, $audit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { //From très particulier
            foreach ($form->all() as $child) {
                if (strpos($child->getName(), 'response_') === 0) {
                    $questionId = str_replace('response_', '', $child->getName()); // On map selon la rep la question associé
                    $question = $questionRepository->find($questionId);
                    if ($question) {
                        $response = new AuditResponse();
                        $response->setQuestion($question);
                        if ($child->getData()) // On vérifié que c'est pas vide 
                            $response->setResponse($child->getData());
                        else { //Si c'est vide on récupère ancienen data si elles sont null on met un string a vide
                            $data = $arr->findOneBy(['audit' => $audit, 'question' => $questionRepository->find($questionId)]) ; // récupère ancienne donnée
                            if($data) //verifie s'il y a des ancienne donnée
                                $response->setResponse($data->getResponse() === null ? '' : $data->getResponse());
                            else
                                $response->setResponse('');
                        }
                        $audit->addAuditResponse($response);
                    }
                    $oldResponse = $arr->findBy(['audit' => $audit]);
                    foreach ($oldResponse as $old) {
                        $em->remove($old);
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
            'rep' => $rep,
            'form' => $form->createView(),
            'themes' => $themes,
            'questions' => $questions,
            'prospect' => $s
        ]);
    }
}
