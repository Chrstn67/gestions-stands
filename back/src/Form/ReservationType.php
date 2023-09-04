<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Stand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('calendar_date')
            ->add('hour_time')
            ->add('statut_resa', ChoiceType::class, [
                'choices' => [
                    'En attente' => 0,
                    'Acceptée' => 1,
                    'Refusée' => 2,
                ],
            ])
            ->add('created_at')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name', 
            ])
            ->add('Stand', EntityType::class, [
                'class' => Stand::class,
                'choice_label' => 'stand_name', 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}