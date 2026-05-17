<?php

namespace App\Controller\Plant;

use App\Entity\Plant;
use App\Service\WikipediaImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexPlantController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/index/plant', name: 'app_index_plant')]
    public function index(WikipediaImageService $imageService): Response
    {
        $plants = $this->em->getRepository(Plant::class)->findAll();

        return $this->render('plant/index.html.twig', [
            'plants'=> $plants,
        ]);
    }
}
