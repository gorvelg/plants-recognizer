<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WikipediaImageService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public function getImagesForPage(string $pageTitle): array
    {
        $response = $this->client->request('GET', 'https://fr.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'titles' => $pageTitle,
                'prop' => 'images',
                'format' => 'json',
                'imlimit' => 20,
            ],
        ]);

        $data = $response->toArray();
        $pages = $data['query']['pages'] ?? [];

        $images = [];

        foreach ($pages as $page) {
            foreach ($page['images'] ?? [] as $image) {
                $images[] = $image['title'];
            }
        }

        return $images;
    }

    public function getImageInfo(string $imageTitle): ?array
    {
        $response = $this->client->request('GET', 'https://fr.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'titles' => $imageTitle,
                'prop' => 'imageinfo',
                'iiprop' => 'url|extmetadata',
                'format' => 'json',
            ],
        ]);

        $data = $response->toArray();

        foreach ($data['query']['pages'] ?? [] as $page) {
            return $page['imageinfo'][0] ?? null;
        }

        return null;
    }
}
