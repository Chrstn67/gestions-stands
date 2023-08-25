<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiStandController extends AbstractController
{
    /**
     * @Route("/api/stands", methods={"GET"})
     */
    public function getStands()
    {
        // Retrieve the list of stands
        // Example: Fetch stands from the database

        // Example response
        $stands = []; // Retrieve stands here
        return new JsonResponse($stands);
    }
}
