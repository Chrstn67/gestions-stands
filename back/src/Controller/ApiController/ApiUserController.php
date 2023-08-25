<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/login", methods={"POST"})
     */
    public function login(Request $request)
    {
        // Retrieve data from the request
        $name = $request->request->get('name');
        $email = $request->request->get('mail');
        $password = $request->request->get('password');
        $role = $request->request->get('role');

        // Handle user login logic here
        // Example: Validate user credentials, create user session, etc.

        // Example response
        return new JsonResponse(['message' => 'User logged in successfully']);
    }
}