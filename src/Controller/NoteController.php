<?php

namespace App\Controller;

use App\Form\NoteFormType;
use App\Repository\NoteRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class NoteController extends AbstractController
{
    private NoteRepository $noteRepository;
    private Security $security;
    private EntityManagerInterface $manager;

    public function __construct( 
        NoteRepository $noteRepository,
        Security $security, 
        EntityManagerInterface $manager)
    {
        $this->noteRepository = $noteRepository;
        $this->security = $security;
        $this->manager = $manager;
    }

    #[Route('/note', name: 'note_list')]
    public function list(): Response
    {
        $notes = $this->noteRepository->findAll();

        return $this->render('note/list.html.twig', [
            'notes' => $notes,
        ]);
    }

    #[Route('/note/{id<\d+>}', name: 'note_detail')]
    public function detail($id): Response
    {
        $note = $this->noteRepository->findOneById($id);

        return $this->render('note/detail.html.twig', [
            'note' => $note,
        ]);
    }

    #[Route('/note/new', name: 'note_new')]
    public function new(Request $request): Response
    {
        $form = $this->createForm(NoteFormType::class);
        $form->handleRequest($request);
        
        if ( $form->isSubmitted() && $form->isValid() ) {
            $note = $form->getData();
            $note->setAuthor($this->security->getUser());
            $note->setCreatedAt(new DateTime('NOW'));
            
            $this->manager->persist($note);
            $this->manager->flush();
            
            return $this->redirectToRoute('note_list');
        }

        return $this->renderForm('note/new.html.twig', [
            'form' => $form,
        ]);
    }

}
