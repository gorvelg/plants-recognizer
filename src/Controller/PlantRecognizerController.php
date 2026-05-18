<?php

namespace App\Controller;

use App\Form\PlantUploadType;
use App\Service\PlantRecognitionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class PlantRecognizerController extends AbstractController
{
    #[Route('/recognize', name: 'plant_index', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        RateLimiterFactoryInterface $anonymousApiLimiter,
        PlantRecognitionService $plantRecognitionService
    ): Response {
        $form = $this->createForm(PlantUploadType::class);
        $form->handleRequest($request);

        $result = null;
        $error = null;


        if ($form->isSubmitted() && $form->isValid()) {

            $limiter = $anonymousApiLimiter->create($request->getClientIp());
            $limit = $limiter->consume(1);
            if (!$limit->isAccepted()) {
                $error = 'Vous avez atteint la limite de 10 reconnaissances par heure.';

                return $this->render('plant_recognizer/index.html.twig', [
                    'form' => $form->createView(),
                    'result' => null,
                    'error' => $error,
                ]);
            }

            $photo = $form->get('photo')->getData();

            if ($photo) {
                $uploadDir = $this->getParameter('app.upload_dir');
                $filename = uniqid('plant_', true) . '.' . $photo->guessExtension();

                try {
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0775, true);
                    }

                    $photo->move($uploadDir, $filename);

                    $filePath = $uploadDir . '/' . $filename;

                    $result = $plantRecognitionService->recognize($filePath);

                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                } catch (FileException $e) {
                    $error = 'Erreur pendant l’envoi du fichier.';
                } catch (\Throwable $e) {
                    $error = $e->getMessage();
                }
            }
        }


        return $this->render('plant_recognizer/index.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
            'error' => $error,
        ]);
    }
}
