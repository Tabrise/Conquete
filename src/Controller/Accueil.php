<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class Accueil extends AbstractController{
    #[Route("/", name:"app_index")]
    public function index() :Response{

        return $this->redirectToRoute('app_societe');
    }
    
}