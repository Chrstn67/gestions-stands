<?php

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiReservationController extends AbstractController
{
    #[Route('/api/reservation', name: 'api_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $reservations = $reservationRepository->findAll();

        $formattedReservations = [];
        foreach ($reservations as $reservation) {
            $formattedReservation = [
                'id' => $reservation->getId(),
                'calendar_date' => $reservation->getCalendarDate()->format('d-m-Y'),
                'hour_time' => $reservation->getHourTime()->format('H:i'),
                'statut_resa' => $reservation->getStatutResa(),
                'created_at' => $reservation->getCreatedAt()->format('d-m-Y H:i'),
                'User' => [

                    'name' => $reservation->getUser()->getName(),
                    
                ],
                'Stand' => [

                    'Location' => $reservation->getStand()->getLocation(),
                   
                ],
            ];

            $formattedReservations[] = $formattedReservation;
        }

        return $this->json($formattedReservations, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('/api/reservation', name: 'api_reservation_addReservation', methods: ['POST'])]

    public function addReservation(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $jsonRecu = $request->getContent();


        try {
            $reservation = $serializer->deserialize($jsonRecu, Reservation::class, 'json');

            $errors = $validator->validate($reservation);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->persist($reservation);
            $em->flush();

            return $this->json($reservation, 201, [], ['groups' => 'reservation:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }


    #[Route('/api/reservation/{id}', name: 'api_reservation_updateReservation', methods: ['PUT'])]
    public function updateReservation(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, Reservation $reservation)
    {
        $jsonRecu = $request->getContent();

        try {
            $updatedReservation = $serializer->deserialize($jsonRecu, Reservation::class, 'json');


            $reservation->setCalendarDate($updatedReservation->getCalendarDate());
            $reservation->setHourTime($updatedReservation->getHourTime());
            $reservation->setStatutResa($updatedReservation->getStatutResa());
            $reservation->setCreatedAt($updatedReservation->getCreatedAt());
            $reservation->setUser($updatedReservation->getUser());
            $reservation->setStand($updatedReservation->getStand());

            $errors = $validator->validate($reservation);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->flush();

            return $this->json($reservation, 200, [], ['groups' => 'reservation:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }
}