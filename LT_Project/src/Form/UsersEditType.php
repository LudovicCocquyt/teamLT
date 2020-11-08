<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\Lineup;
use App\Entity\Images;
use App\Entity\Users;
use App\Entity\Jeux;


class UsersEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'required' => true
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('username', TextType::class,[
                'required' => true
            ])
            ->add('description', TextareaType::class,[
                'required' => false
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur'    => 'ROLE_USER',
                    'Editeur'        => 'ROLE_EDITOR',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Super admin'    => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
                'label'    => 'Rôles' 
            ])
            ->add('birthday', DateType::class, array(
                    'label'    => 'Date de naissance',
                    'years'    => range(date('1970'), date('Y')),
                    'required' => true,
                ))
            ->add('isActive', ChoiceType::class, [
                        'choices'  => [
                                        'Oui' => true,
                                        'Non' => false,
                                       ],])
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
            ->add('nationality', ChoiceType::class, [
                        'choices'  => [
                                        'Europe'         => 'eu.png',
                                        'Austria'        => 'au.png',
                                        'Belgium'        => 'be.png',
                                        'Bulgaria'       => 'bul.png',
                                        'Cyprus'         => 'cy.png',
                                        'Czech Republic' => 'cr.png',
                                        'Denmark'        => 'da.png',
                                        'Estonia'        => 'est.png',
                                        'Finland'        => 'fi.png',
                                        'France'         => 'fr.png',
                                        'Germany'        => 'de.svg',
                                        'Greece'         => 'gr.png',
                                        'Hungary'        => 'hu.svg',
                                        'Italy'          => 'it.png',
                                        'Ireland'        => 'ir.svg',
                                        'Latvia'         => 'lat.svg',
                                        'Luxembourg'     => 'lux.png',
                                        'Lithuania'      => 'lit.png',
                                        'Malta'          => 'mal.png',
                                        'Netherlands'    => 'ner.png',
                                        'Norway'         => 'nor.png',
                                        'Poland'         => 'po.png',
                                        'Portugal'       => 'por.png',
                                        'Romania'        => 'ro.png',
                                        'Switzerland'    => 'ch.png',
                                        'Slovenia'       => 'Slo.svg',
                                        'Slovakia'       => 'slo.png',
                                        'Spain'          => 'esp.png',
                                        'Sweden'         => 'Swe.png',
                                        'United Kingdom' => 'uk.svg',
                                       ],])
            ->add('description', TextareaType::class,[
                'required'   => false
            ])
            ->add('images', FileType::class,[
                'label'    => false,
                'multiple' => false,
                'mapped'   => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
