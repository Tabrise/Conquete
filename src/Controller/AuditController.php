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
    
}
