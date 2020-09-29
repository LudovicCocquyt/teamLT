<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use App\Entity\Users;

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
            ->add('description', TextareaType::class)
            ->add('birthday', DateType::class, array(
                    'label'    => 'Date de naissance',
                    'years'    => range(date('1970'), date('Y')),
                    'required' => true,
                ))
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}