<?php

namespace App\Controller;

use App\Entity\Plant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlantSaveController extends AbstractController
{
    #[Route('/plant/save', name: 'plant_save', methods: ['POST'])]
    public function save(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $plant = new Plant();

        $plant
            ->setCommonName($request->request->get('common_name'))
            ->setScientificName($request->request->get('scientific_name'))
            ->setWatering($request->request->get('watering'))
            ->setWateringSmall($request->request->get('watering_small'))
            ->setExposure($request->request->get('exposure'))
            ->setExposureSmall($request->request->get('exposure_small'))
            ->setSoil($request->request->get('soil'))
            ->setFamily($request->request->get('family'))
            ->setDisease($request->request->get('disease'))
            ->setRepotting($request->request->get('repotting'))
            ->setRepottingSmall($request->request->get('repotting_small'))
            ->setHumidity($request->request->get('humidity'))
            ->setTemperature($request->request->get('temperature'))
            ->setTemperatureNumber($request->request->get('temperature_number'))
            ->setConfidence(
                $request->request->get('confidence') !== null
                    ? (float) $request->request->get('confidence')
                    : null
            )
            ->setDescription($request->request->get('description'))
            ->setPlantingPeriod($request->request->get('planting_period'))
            ->setPlantingDistance($request->request->get('planting_distance'))
            ->setFertilizer($request->request->get('fertilizer'))
            ->setHeight($request->request->get('height'))
            ->setWidth($request->request->get('width'))
            ->setFoliage($request->request->get('foliage'))
            ->setFoliageType($request->request->get('foliage_type'))
            ->setShape($request->request->get('shape'))
            ->setFlowers($request->request->get('flowers'))
            ->setBloomPeriod($request->request->get('bloom_period'))
            ->setFruits($request->request->get('fruits'))
            ->setToxicity($request->request->getBoolean('toxicity'))
            ->setIsSafeGuess($request->request->getBoolean('is_safe_guess'))
            ->setCareTips($request->request->all('care_tips'));

        $entityManager->persist($plant);
        $entityManager->flush();

        $this->addFlash('success', 'La fiche plante a bien été enregistrée.');

        return $this->redirectToRoute('plant_index');
    }
}
