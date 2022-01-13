<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    private NoteRepository $noteRepository;

    public function __construct( NoteRepository $noteRepository )
    {
        $this->noteRepository = $noteRepository;
    }

    #[Route('/note', name: 'note_list')]
    public function list(): Response
    {
        $notes = $this->noteRepository->findAll();

        return $this->render('note/note_list.html.twig', [
            'notes' => $notes,
        ]);
    }

    #[Route('/note/{id}', name: 'note_detail')]
    public function detail($id): Response
    {
        $note = $this->noteRepository->findOneById($id);

        return $this->render('note/note_detail.html.twig', [
            'note' => $note,
        ]);
    }

}
