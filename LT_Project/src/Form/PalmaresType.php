<?php

namespace App\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\Palmares;
use App\Entity\Lineup;
use App\Entity\Users;
use App\Entity\Jeux;

class PalmaresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date')
            ->add('rank')
            ->add('lineup', EntityType::class, [
                    'class'        => Lineup::class,
                    'required'     => true,
                    'choice_label' => 'name',
                    'multiple'     => false,
                ])
            ->add('jeux', EntityType::class, [
                    'class'        => Jeux::class,
                    'required'     => true,
                    'choice_label' => 'name',
                    'multiple'     => false,
                ])
            ->add('user', EntityType::class, [
                    'class'        => Users::class,
                    'required'     => false,
                    'choice_label' => 'userName',
                    'multiple'     => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Palmares::class,
        ]);
    }
}
