<?php

namespace App\Controller;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
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
                    'email' => $reservation->getUser()->getEmail(),
                    'password' => $reservation->getUser()->getPassword(),
                    'roles' => $reservation->getUser()->getRoles(),

                ],
                'Stand' => [

                    'location' => $reservation->getStand()->getLocation(),
                    'name' => $reservation->getStand()->getStandName(),

                ],
            ];

            $formattedReservations[] = $formattedReservation;
        }

        return $this->json($formattedReservations, 200, [], ['groups' => 'reservation:read']);
    }

    #[Route('/api/reservation/{id}', name: 'api_reservation_getSingleReservation', methods: ['GET'])]
    public function getSingleReservation(ReservationRepository $reservationRepository, int $id): Response
    {
        try {
            $reservation = $reservationRepository->find($id);

            if (!$reservation) {
                throw new EntityNotFoundException("Reservation with ID $id not found.");
            }

            $formattedReservation = [
                'id' => $reservation->getId(),
                'calendar_date' => $reservation->getCalendarDate()->format('d-m-Y'),
                'hour_time' => $reservation->getHourTime()->format('H:i'),
                'statut_resa' => $reservation->getStatutResa(),
                'created_at' => $reservation->getCreatedAt()->format('d-m-Y H:i'),
                'User' => [
                    'name' => $reservation->getUser()->getName(),
                    'email' => $reservation->getUser()->getEmail(),
                    'password' => $reservation->getUser()->getPassword(),
                    'roles' => $reservation->getUser()->getRoles(),
                ],
                'Stand' => [
                    'location' => $reservation->getStand()->getLocation(),
                    'name' => $reservation->getStand()->getStandName(),
                ],
            ];

            return $this->json($formattedReservation, 200, [], ['groups' => 'reservation:read']);
        } catch (EntityNotFoundException $exception) {
            return $this->json(['message' => $exception->getMessage()], 404);
        }
    }





    #[Route('/api/reservation/{id}', name: 'api_reservation_addReservation', methods: ['POST'])]

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

    #[Route('/api/reservation/{id}', name: 'api_reservation_deleteReservation', methods: ['DELETE'])]
public function deleteReservation(Reservation $reservation, EntityManagerInterface $em)
{
    try {
       
        $em->remove($reservation);
        $em->flush();

       
        return new Response(null, 204);
    } catch (EntityNotFoundException $exception) {
        return $this->json(['message' => $exception->getMessage()], 404);
    }
}
}
