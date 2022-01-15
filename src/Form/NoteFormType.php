<?php

namespace App\Form;

use DateTime;
use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class NoteFormType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $now = new DateTime('NOW');
        
        $builder
            ->add('title')
            ->add('note')
            ->add('createdAt', TextType::class, [
                'data' => $now->format('D M d, Y, G:i'),
                'disabled' => true,
            ])
            ->add('author', TextType::class, [
                'data' => $this->security->getUser(),
                'disabled' => true,
            ])
            ->add('add', SubmitType::class, [
                'label' => 'Add Note'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
