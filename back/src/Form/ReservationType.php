<?php

namespace App\Form;


use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Stand;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;

class ReservationType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        $choices = [];
        foreach ($users as $user) {
            $choices[$user->getName()] = $user->getId();
        }

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
            ->add('User', ChoiceType::class, [
                'choices' => $choices,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Utilisateurs',
                'label_attr' => [
                    'class' => 'checkbox-inline',
                ],
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