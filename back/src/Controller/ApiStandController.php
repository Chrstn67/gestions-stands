<?php

namespace App\Controller;

use App\Entity\Stand;
use App\Repository\StandRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiStandController extends AbstractController
{
    #[Route('/api/stand', name: 'api_stand_index', methods: ['GET'])]

    public function index(StandRepository $standRepository): Response
    {
        return $this->json($standRepository->findAll(), 200, [], ['groups' => 'stand:read']);
    }

    #[Route('/api/stand/{id}', name: 'api_stand_getSingleStand', methods: ['GET'])]
    public function getSingleStand(StandRepository $standRepository, int $id): Response
    {
        try {
            $stand = $standRepository->find($id);

            if (!$stand) {
                throw new EntityNotFoundException("Stand with ID $id not found.");
            }

            return $this->json($stand, 200, [], ['groups' => 'stand:read']);
        } catch (EntityNotFoundException $exception) {
            return $this->json(['message' => $exception->getMessage()], 404);
        }
    }


    #[Route('/api/stand', name: 'api_stand_addStand', methods: ['POST'])]

    public function addStand(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $jsonRecu = $request->getContent();


        try {
            $stand = $serializer->deserialize($jsonRecu, Stand::class, 'json');

            $errors = $validator->validate($stand);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->persist($stand);
            $em->flush();

            return $this->json($stand, 201, [], ['groups' => 'stand:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }


    #[Route('/api/stand/{id}', name: 'api_stand_updateStand', methods: ['PUT'])]
    public function updateStand(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, Stand $stand)
    {
        $jsonRecu = $request->getContent();

        try {
            $updatedStand = $serializer->deserialize($jsonRecu, Stand::class, 'json');


            $stand->setStandName($updatedStand->getStandName());
            $stand->setLocation($updatedStand->getLocation());

            $errors = $validator->validate($stand);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->flush();

            return $this->json($stand, 200, [], ['groups' => 'stand:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }
}
