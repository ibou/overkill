<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OverkillController extends AbstractController
{
    #[Route('/', name: 'overkill')]
    public function index(Request $request): Response
    {
        
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($upload);
            $this->entityManager->flush();
            $this->redirectToRoute('overkill'); 
        }
        return $this->render('overkill/index.html.twig', [
            'controller_name' => 'OverkillController',
            'form' => $form->createView()
        ]);
    }
}
