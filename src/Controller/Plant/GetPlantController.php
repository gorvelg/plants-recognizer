<?php

namespace App\Controller\Plant;

use App\Entity\Plant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetPlantController extends AbstractController
{
    #[Route('/get/plant/{plant}', name: 'app_get_plant')]
    public function index(Plant $plant): Response
    {
        return $this->render('plant/get.html.twig', [
            'plant' => $plant,
        ]);
    }
}
