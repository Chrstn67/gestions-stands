<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Lambda' => 'ROLE_USER',
                    'Moderateur' => 'ROLE_MODO',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true,
                'expanded' => true,
                'label' => 'Rôle(s)',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
            ])
            ->add('email')
            ->add('password')
            ->add('reservation', CollectionType::class, [
                'entry_type' => ReservationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}