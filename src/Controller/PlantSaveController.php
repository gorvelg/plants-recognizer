<?php

namespace App\Controller;

use App\Entity\Attachment;
use App\Entity\Plant;
use App\Service\WikipediaImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class PlantSaveController extends AbstractController
{
    #[Route('/plant/save', name: 'plant_save', methods: ['POST'])]
    public function save(
        Request $request,
        EntityManagerInterface $entityManager,
        WikipediaImageService $wikipediaImageService,
        HttpClientInterface $httpClient,
    ): Response {

        $scientificName = $request->request->get('scientific_name');

        if (!$scientificName) {
            $this->addFlash('error', 'Impossible d’enregistrer cette fiche.');
            return $this->redirectToRoute('plant_index');
        }

        $existingPlant = $entityManager->getRepository(Plant::class)->findOneBy([
            'scientificName' => $scientificName
        ]);

        if ($existingPlant) {
            $this->addFlash('info', 'Cette plante a déjà été enregistrée.');
            return $this->redirectToRoute('plant_index');
        }

        $image = $wikipediaImageService->getMainImageForPage($scientificName);


//        dump($image);


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

        if ($image !== null && isset($image['url'])) {
            $imageUrl = $image['url'];

            $response = $httpClient->request('GET', $imageUrl);

            if ($response->getStatusCode() === 200) {
                $content = $response->getContent();

                $headers = $response->getHeaders(false);
                $mimeType = $headers['content-type'][0] ?? 'image/jpeg';

                $sizeBytes = strlen($content);

                $originalFilename = basename(parse_url($imageUrl, PHP_URL_PATH));
                $extension = pathinfo($originalFilename, PATHINFO_EXTENSION) ?: 'jpg';

                $newFilename = uniqid('plant_', true) . '.' . $extension;

                $uploadDirectory = $this->getParameter('plant_uploads_directory');

                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0775, true);
                }

                $fullPath = $uploadDirectory . '/' . $newFilename;

                file_put_contents($fullPath, $content);

                $attachment = new Attachment();

                $attachment
                    ->setPlant($plant)
                    ->setOriginalFilename($originalFilename)
                    ->setMimeType($mimeType)
                    ->setSizeBytes($sizeBytes)
                    ->setPath('/uploads/plants/' . $newFilename)
                    ->setWidth($image['width'] ?? null)
                    ->setHeight($image['height'] ?? null);

                $entityManager->persist($attachment);
            }
        }

        $entityManager->flush();

        $this->addFlash('success', 'La fiche plante a bien été enregistrée.');

        return $this->redirectToRoute('plant_index');
    }
}
