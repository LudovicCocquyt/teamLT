<?php

namespace App\Form;

use App\Entity\Lineup;
use App\Entity\Jeux;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LineupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isActive')
            ->add('name')
            ->add('tag')
            ->add('image')
            ->add('users', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Users::class,
                    'required' => false,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'userName',

                    // used to render a select box, check boxes or radios
                     'multiple' => true,
                    // 'expanded' => true,
                ])
            ->add('jeux', EntityType::class, [
                    // looks for choices from this entity
                    'class' => Jeux::class,
                    'required' => false,

                    // uses the User.username property as the visible option string
                    'choice_label' => 'name',

                    // used to render a select box, check boxes or radios
                     'multiple' => true,
                    // 'expanded' => true,
                ])
            ->add('description', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lineup::class,
        ]);
    }
}
