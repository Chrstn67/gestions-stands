<?php

namespace App\Controller;

use App\Entity\Stand;
use App\Entity\Reservation;
use App\Form\UserDashboardReservationType;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function index(Request $request, StandRepository $standRepository): Response
    {
        // Retrieve and display available slots.
        $availableStands = $standRepository->findAvailableStands(); // Implement this method in StandRepository.

        $reservation = new Reservation();
        $form = $this->createForm(UserDashboardReservationType::class, $reservation);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle the reservation here, create a new Reservation entity and associate it with the user.
            // Redirect to a success page or back to the dashboard.
        }

        return $this->render('user_dashboard/index.html.twig', [
            'stands' => $availableStands,
            'form' => $form->createView(),
        ]);
    }
}
