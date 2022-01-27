<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Form\UploadType;
use App\Message\UploadMessage;
use Doctrine\Persistence\ManagerRegistry;
use App\MessageHandler\UploadMessageHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OverkillController extends AbstractController
{
    #[Route('/', name: 'overkill')]
    public function index(Request $request, ManagerRegistry $doctrine, MessageBusInterface $bus): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $entityManager = $doctrine->getManager();
        $upload = new Upload();
        $form = $this->createForm(UploadType::class, $upload);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $upload->setUploadBy($this->getUser());
            $entityManager->persist($upload);
            $entityManager->flush();
            $bus->dispatch(new UploadMessage($upload->getImageFile(), $this->getUser()->getUserIdentifier()));
            $this->redirectToRoute('overkill'); 
        }
        return $this->render('overkill/index.html.twig', [
            'controller_name' => 'OverkillController',
            'form' => $form->createView()
        ]);
    }
}
