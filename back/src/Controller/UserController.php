<?php

namespace App\Controller;


use App\Entity\Stand;
use App\Form\ReservationType;

use App\Entity\Reservation;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ReservationRepository;
use App\Repository\StandRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before persisting the user
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before updating the user
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/dashboard/{id}', name: 'app_user_dashboard')]
    public function dashboard(ReservationRepository $reservationRepository): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createAccessDeniedException('Utilisateur non connecté.');
        }

        // Utilisez une requête personnalisée pour récupérer les réservations de l'utilisateur
        $reservations = $reservationRepository->findReservationsByUser($user);

        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'reservations' => $reservations,
        ]);
    }


    // #[Route('/dashboard', name: 'app_user_dashboard', methods: ['GET'])]
    // public function dashboard(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    // {
    //     $stands = $entityManager->getRepository(Stand::class)->findAll();
    //     $reservations = $reservationRepository->findBy(['user' => $this->getUser()]);

    //     return $this->render('user/dashboard.html.twig', [
    //         'stands' => $stands,
    //         'reservations' => $reservations,
    //     ]);
    // }

    // #[Route('/dashboard/reservation/{standId}', name: 'app_make_reservation', methods: ['GET', 'POST'])]
    // #[ParamConverter('stand', options: ['mapping' => ['standId' => 'id']])]
    // public function makeReservation(Request $request, Stand $stand, EntityManagerInterface $entityManager): Response
    // {
    //     // Récupérer l'utilisateur actuellement connecté
    //     $user = $this->getUser();

    //     if (!$user) {
    //         throw $this->createNotFoundException('L\'utilisateur n\'est pas connecté.');
    //     }

    //     $stands = $entityManager->getRepository(Stand::class)->findAll();

    //     $reservation = new Reservation();
    //     $reservation->setUser($user);
    //     $reservation->setStand($stand); // Définir le stand sélectionné

    //     $form = $this->createForm(ReservationType::class, $reservation, [
    //         'stands' => $stands,
    //     ]);

    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // Gérer la réservation ici

    //         $entityManager->persist($reservation);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_user_dashboard');
    //     }

    //     return $this->render('user/make_reservation.html.twig', [
    //         'form' => $form->createView(),
    //     ]);
    // }
}
