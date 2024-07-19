<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeType;
use App\Repository\QuestionRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/theme')]
class ThemeController extends AbstractController
{
    #[Route('/', name: 'app_theme_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $themes = $em->getRepository(Theme::class)->findBy([], ['ordre' => 'ASC']);
        return $this->render('theme/index.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/new', name: 'app_theme_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ThemeRepository $themeRepository): Response
    {
        $theme = new Theme();
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maxOrder = $themeRepository->createQueryBuilder('t')
                ->select('MAX(t.ordre)')
                ->getQuery()
                ->getSingleScalarResult();
            $theme->setOrdre($maxOrder + 1);
            $entityManager->persist($theme);
            $entityManager->flush();

            return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('theme/new.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_theme_show', methods: ['GET'])]
    public function show(Theme $theme): Response
    {
        return $this->render('theme/show.html.twig', [
            'theme' => $theme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_theme_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Theme $theme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ThemeType::class, $theme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('theme/edit.html.twig', [
            'theme' => $theme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/remove', name: 'app_theme_delete', methods: ['POST'])]
    public function delete(Request $request, Theme $theme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $theme->getId(), $request->request->get('_token'))) {
            $entityManager->remove($theme);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_theme_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/order', name: 'theme_order', methods: ['POST'])]
    public function ordre(Request $request, ThemeRepository $themeRepository, QuestionRepository $questionRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['themeOrder']) && is_array($data['themeOrder'])) {
            foreach ($data['themeOrder'] as $index => $themeId) {
                $theme = $themeRepository->find($themeId);
                if ($theme) {
                    $theme->setOrdre($index + 1);
                }
            }
        }

        if (isset($data['questionOrders']) && is_array($data['questionOrders'])) {
            foreach ($data['questionOrders'] as $themeId => $order) {
                foreach ($order as $index => $questionId) {
                    $question = $questionRepository->find($questionId);
                    if ($question) {
                        $question->setOrdre($index + 1);
                    }
                }
            }
        }

        $em->flush();

        return new JsonResponse(['status' => 'Order updated']);
    }
}
