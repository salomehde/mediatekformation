<?php

namespace App\Form;

use App\Entity\Formation;
use App\Entity\Playlist;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use DateTime;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('publishedAt', DateType::class, [
                'label' => 'Date',
                'data' => isset($options['data']) && $options['data']->getPublishedAt() != null ? $options['data']->getPublishedAt() : new DateTime('now'),
                'widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new LessThanOrEqual([
                        'value'=> 'today',
                        'message' => 'La date doit être inférieure ou égale à maintenant'
                    ]),                  
                ]
                ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            ->add('videoId', TextType::class, [
                'label' => 'Video ID',
                'required' => true
            ])
            ->add('playlist', EntityType::class, [
                'class' => Playlist::class,
                'label' => 'Playlist',
                'choice_label' => 'name',
                'required' => true
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Catégories',
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
