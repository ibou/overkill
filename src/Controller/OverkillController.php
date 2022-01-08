<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OverkillController extends AbstractController
{
    #[Route('/', name: 'overkill')]
    public function index(): Response
    {
        return $this->render('overkill/index.html.twig', [
            'controller_name' => 'OverkillController',
        ]);
    }
}
