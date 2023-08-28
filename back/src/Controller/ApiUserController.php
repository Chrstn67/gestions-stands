<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiUserController extends AbstractController
{
    #[Route('/api/user', name: 'api_user_index', methods: ['GET'])]

    public function index(UserRepository $userRepository): Response
    {
        return $this->json($userRepository->findAll(), 200, [], ['groups' => 'user:read']);
    }


    #[Route('/api/user', name: 'api_user_addUser', methods: ['POST'])]

    public function addUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {
        $jsonRecu = $request->getContent();


        try {
            $user = $serializer->deserialize($jsonRecu, User::class, 'json');

            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->persist($user);
            $em->flush();

            return $this->json($user, 201, [], ['groups' => 'post:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }




    #[Route('/api/user/{id}', name: 'api_user_updateUser', methods: ['PUT'])]
    public function updateUser(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator, User $user)
    {
        $jsonRecu = $request->getContent();

        try {
            $updatedUser = $serializer->deserialize($jsonRecu, User::class, 'json');

            // Copy the properties from $updatedUser to $user
            $user->setEmail($updatedUser->getEmail());
            $user->setPassword($updatedUser->getPassword());
            $user->setRoles($updatedUser->getRoles());
            $user->setName($updatedUser->getName());

            $errors = $validator->validate($user);

            if (count($errors) > 0) {
                return $this->json($errors, 400);
            }

            $em->flush();

            return $this->json($user, 200, [], ['groups' => 'user:read']);
        } catch (NotEncodableValueException $exception) {
            return $this->json(['status' => 400, 'message' => $exception->getMessage()], 400);
        }
    }
}