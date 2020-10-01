<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\Resultats;
use App\Entity\Lineup;
use App\Entity\Users;
use App\Entity\Jeux;

class ResultatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('name')
            ->add('mapOne')
            ->add('mapTwo')
                    // looks for choices from this entity
            ->add('jeu', EntityType::class, [
                    'class'    => Jeux::class,
                    'required' => true,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'name',

                    // used to render a select box, check boxes or radios
                     'multiple' => false,
                    // 'expanded' => true,
                ])
            ->add('lineup', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Lineup::class,
                    'required' => true,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'name',

                    // used to render a select box, check boxes or radios
                     'multiple' => false,
                    // 'expanded' => true,
                ])
            ->add('scoreOne')
            ->add('teamAdverse')
            ->add('scoreTwo')
            ->add('user', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Users::class,
                    'required' => false,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'userName',

                    // used to render a select box, check boxes or radios
                     'multiple' => true,
                    // 'expanded' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resultats::class,
        ]);
    }
}
