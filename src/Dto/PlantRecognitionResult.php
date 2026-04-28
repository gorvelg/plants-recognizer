<?php

namespace App\DTO;

class PlantRecognitionResult
{
    public function __construct(
        public ?string $commonName = null,
        public ?string $scientificName = null,
        public ?string $watering = null,
        public ?string $watering_small = null,
        public ?string $exposure = null,
        public ?string $exposure_small = null,
        public ?string $soil = null,
        public ?string $family  = null,
        public ?string $disease = null,
        public ?string $repotting = null,
        public ?string $repotting_small = null,
        public ?string $humidity = null,
        public ?string $temperature = null,
        public ?string $temperature_number = null,
        public ?float $confidence = null,
        public ?string $description = null,
        public array $careTips = [],
        public bool $isSafeGuess = false
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            commonName: $data['common_name'] ?? null,
            scientificName: $data['scientific_name'] ?? null,
            watering: $data['watering'] ?? null,
            watering_small: $data['watering_small'] ?? null,
            exposure: $data['exposure'] ?? null,
            exposure_small: $data['exposure_small'] ?? null,
            repotting: $data['repotting'] ?? null,
            repotting_small: $data['repotting_small'] ?? null,
            soil: $data['soil'] ?? null,
            family: $data['family'] ?? null,
            disease: $data['disease'] ?? null,
            humidity: $data['humidity'] ?? null,
            temperature: $data['temperature'] ?? null,
            temperature_number: $data['temperature_number'] ?? null,
            confidence: isset($data['confidence']) ? (float) $data['confidence'] : null,
            description: $data['description'] ?? null,
            careTips: is_array($data['care_tips'] ?? null) ? $data['care_tips'] : [],
            isSafeGuess: (bool) ($data['is_safe_guess'] ?? false),
        );
    }
}
