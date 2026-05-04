<?php

namespace App\Service;

use App\Dto\PlantRecognitionResult;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PlantRecognitionService
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $apiKey,
        private string $model
    ) {
    }

    public function recognize(string $imagePath): PlantRecognitionResult
    {
        if (!is_file($imagePath)) {
            throw new \RuntimeException('Image introuvable.');
        }

        $mimeType = mime_content_type($imagePath);
        if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'], true)) {
            throw new \RuntimeException('Format de fichier non supporté.');
        }

        $base64 = base64_encode(file_get_contents($imagePath));
        $dataUrl = sprintf('data:%s;base64,%s', $mimeType, $base64);

        $payload = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Tu es un assistant botanique français. Réponds uniquement avec un JSON valide.'
                        ]
                    ]
                ],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => <<<TEXT
Analyse cette photo et identifie la plante.
Réponds uniquement en JSON valide avec les champs suivants :
common_name,
scientific_name,
confidence,
watering,
watering_small,
exposure,
exposure_small,
family,
humidity,
disease,
temperature,
temperature_number,
soil,
repotting,
repotting_small,
description,
planting_period,
planting_distance,
fertilizer,
height,
width,
foliage,
foliage_type,
shape,
flowers,
bloom_period,
fruits,
toxicity,
care_tips,
is_safe_guess

Contraintes :
- confidence = nombre entre 0 et 1
- temperature = courte phrase
- temperature_number = plage de temperature en degré celsius.
- exposure = courte phrase
- exposure_small = un ou deux mots maximum
- watering = courte phrase
- watering_small = un ou deux mots maximum
- repotting_small = uniquement la periodicité, sans faire de phrase.
- toxicity = si toxique pour les animaux, mettre true sinon false.
- care_tips = tableau de 3 conseils maximum
- si l'image est insuffisante, propose la meilleure hypothèse mais mets is_safe_guess à false
- n'invente pas une certitude
TEXT
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => $dataUrl,
                                'detail' => 'high'
                            ]
                        ]
                    ]
                ]
            ],
            'temperature' => 0.2,
        ];

        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);

        $data = $response->toArray(false);

        $content = $data['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new \RuntimeException('Réponse vide de l’API.');
        }

        $content = trim($content);

        $content = preg_replace('/^```json\s*/i', '', $content);
        $content = preg_replace('/^```\s*/', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);

        $decoded = json_decode(trim($content), true);

        if (!is_array($decoded)) {
            throw new \RuntimeException('Réponse JSON invalide : ' . $content);
        }

        return PlantRecognitionResult::fromArray($decoded);
    }
}
