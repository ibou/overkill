<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OverkillController extends AbstractController
{
    #[Route('/', name: 'overkill')]
    public function index(Request $request, ManagerRegistry $doctrine ): Response
    {
        $entityManager = $doctrine->getManager();
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($upload);
            $entityManager->flush();
            $this->redirectToRoute('overkill'); 
        }
        return $this->render('overkill/index.html.twig', [
            'controller_name' => 'OverkillController',
            'form' => $form->createView()
        ]);
    }
}
