<?php

namespace App\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\Resultats;
use App\Entity\Lineup;

class ResultatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('name')
            ->add('mapOne')
            ->add('mapTwo')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Resultats::class,
        ]);
    }
}
