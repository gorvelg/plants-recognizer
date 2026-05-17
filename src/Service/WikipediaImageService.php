<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WikipediaImageService
{
    public function __construct(
        private HttpClientInterface $client,
    ) {}

    public function getMainImageForPage(string $pageTitle): ?array
    {
        $mainImage = $this->getPageImage($pageTitle);

        if ($mainImage !== null) {
            return $mainImage;
        }

        return $this->getFirstArticleImage($pageTitle);
    }

    private function getPageImage(string $pageTitle): ?array
    {
        $response = $this->client->request('GET', 'https://fr.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'titles' => $pageTitle,
                'prop' => 'pageimages',
                'format' => 'json',
                'pithumbsize' => 800,
                'origin' => '*',
            ],
        ]);

        $data = $response->toArray();

        foreach ($data['query']['pages'] ?? [] as $page) {
            if (!isset($page['thumbnail']['source'])) {
                continue;
            }

            return [
                'url' => $page['thumbnail']['source'],
                'width' => $page['thumbnail']['width'] ?? null,
                'height' => $page['thumbnail']['height'] ?? null,
                'mimeType' => null,
                'title' => $page['title'] ?? $pageTitle,
            ];
        }

        return null;
    }

    private function getFirstArticleImage(string $pageTitle): ?array
    {
        $response = $this->client->request('GET', 'https://fr.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'titles' => $pageTitle,
                'prop' => 'images',
                'format' => 'json',
                'imlimit' => 50,
                'origin' => '*',
            ],
        ]);

        $data = $response->toArray();

        foreach ($data['query']['pages'] ?? [] as $page) {
            foreach ($page['images'] ?? [] as $image) {
                $imageTitle = $image['title'] ?? null;

                if ($imageTitle === null) {
                    continue;
                }

                $imageInfo = $this->getImageInfo($imageTitle);

                if ($imageInfo === null) {
                    continue;
                }

                if (!$this->isValidMimeType($imageInfo['mimeType'] ?? null)) {
                    continue;
                }

                return $imageInfo;
            }
        }

        return null;
    }

    private function getImageInfo(string $imageTitle): ?array
    {
        $response = $this->client->request('GET', 'https://fr.wikipedia.org/w/api.php', [
            'query' => [
                'action' => 'query',
                'titles' => $imageTitle,
                'prop' => 'imageinfo',
                'iiprop' => 'url|size|mime',
                'format' => 'json',
                'origin' => '*',
            ],
        ]);

        $data = $response->toArray();

        foreach ($data['query']['pages'] ?? [] as $page) {
            $info = $page['imageinfo'][0] ?? null;

            if ($info === null || !isset($info['url'])) {
                continue;
            }

            return [
                'url' => $info['url'],
                'width' => $info['width'] ?? null,
                'height' => $info['height'] ?? null,
                'mimeType' => $info['mime'] ?? null,
                'title' => $page['title'] ?? $imageTitle,
            ];
        }

        return null;
    }

    private function isValidMimeType(?string $mimeType): bool
    {
        return in_array($mimeType, [
            'image/jpeg',
            'image/png',
            'image/webp',
        ], true);
    }
}
