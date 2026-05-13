<?php

namespace App\Entity;

use App\Repository\PlantsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlantsRepository::class)]
class Plant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $commonName = null;

    #[ORM\Column(length: 255)]
    private ?string $scientificName = null;

    #[ORM\Column(length: 255)]
    private ?string $watering = null;

    #[ORM\Column(length: 255)]
    private ?string $wateringSmall = null;

    #[ORM\Column(length: 255)]
    private ?string $exposure = null;

    #[ORM\Column(length: 255)]
    private ?string $exposureSmall = null;

    #[ORM\Column(length: 255)]
    private ?string $soil = null;

    #[ORM\Column(length: 255)]
    private ?string $family = null;

    #[ORM\Column(length: 255)]
    private ?string $disease = null;

    #[ORM\Column(length: 255)]
    private ?string $repotting = null;

    #[ORM\Column(length: 255)]
    private ?string $repottingSmall = null;

    #[ORM\Column(length: 255)]
    private ?string $humidity = null;

    #[ORM\Column(length: 255)]
    private ?string $temperature = null;

    #[ORM\Column(length: 255)]
    private ?string $temperatureNumber = null;

    #[ORM\Column(nullable: true)]
    private ?float $confidence = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $plantingPeriod = null;

    #[ORM\Column(length: 100)]
    private ?string $plantingDistance = null;

    #[ORM\Column(length: 255)]
    private ?string $fertilizer = null;

    #[ORM\Column(length: 100)]
    private ?string $height = null;

    #[ORM\Column(length: 100)]
    private ?string $width = null;

    #[ORM\Column(length: 255)]
    private ?string $foliage = null;

    #[ORM\Column(length: 255)]
    private ?string $foliageType = null;

    #[ORM\Column(length: 255)]
    private ?string $shape = null;

    #[ORM\Column(length: 255)]
    private ?string $flowers = null;

    #[ORM\Column(length: 255)]
    private ?string $bloomPeriod = null;

    #[ORM\Column(length: 255)]
    private ?string $fruits = null;

    #[ORM\Column(length: 255)]
    private ?string $toxicity = null;

    #[ORM\Column]
    private array $careTips = [];

    #[ORM\Column]
    private ?bool $isSafeGuess = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommonName(): ?string
    {
        return $this->commonName;
    }

    public function setCommonName(string $commonName): static
    {
        $this->commonName = $commonName;

        return $this;
    }

    public function getScientificName(): ?string
    {
        return $this->scientificName;
    }

    public function setScientificName(string $scientificName): static
    {
        $this->scientificName = $scientificName;

        return $this;
    }

    public function getWatering(): ?string
    {
        return $this->watering;
    }

    public function setWatering(string $watering): static
    {
        $this->watering = $watering;

        return $this;
    }

    public function getWateringSmall(): ?string
    {
        return $this->wateringSmall;
    }

    public function setWateringSmall(string $wateringSmall): static
    {
        $this->wateringSmall = $wateringSmall;

        return $this;
    }

    public function getExposure(): ?string
    {
        return $this->exposure;
    }

    public function setExposure(string $exposure): static
    {
        $this->exposure = $exposure;

        return $this;
    }

    public function getExposureSmall(): ?string
    {
        return $this->exposureSmall;
    }

    public function setExposureSmall(string $exposureSmall): static
    {
        $this->exposureSmall = $exposureSmall;

        return $this;
    }

    public function getSoil(): ?string
    {
        return $this->soil;
    }

    public function setSoil(string $soil): static
    {
        $this->soil = $soil;

        return $this;
    }

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getDisease(): ?string
    {
        return $this->disease;
    }

    public function setDisease(string $disease): static
    {
        $this->disease = $disease;

        return $this;
    }

    public function getRepotting(): ?string
    {
        return $this->repotting;
    }

    public function setRepotting(string $repotting): static
    {
        $this->repotting = $repotting;

        return $this;
    }

    public function getRepottingSmall(): ?string
    {
        return $this->repottingSmall;
    }

    public function setRepottingSmall(string $repottingSmall): static
    {
        $this->repottingSmall = $repottingSmall;

        return $this;
    }

    public function getHumidity(): ?string
    {
        return $this->humidity;
    }

    public function setHumidity(string $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getTemperature(): ?string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): static
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getTemperatureNumber(): ?string
    {
        return $this->temperatureNumber;
    }

    public function setTemperatureNumber(string $temperatureNumber): static
    {
        $this->temperatureNumber = $temperatureNumber;

        return $this;
    }

    public function getConfidence(): ?string
    {
        return $this->confidence;
    }

    public function setConfidence(string $confidence): static
    {
        $this->confidence = $confidence;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPlantingPeriod(): ?string
    {
        return $this->plantingPeriod;
    }

    public function setPlantingPeriod(string $plantingPeriod): static
    {
        $this->plantingPeriod = $plantingPeriod;

        return $this;
    }

    public function getPlantingDistance(): ?string
    {
        return $this->plantingDistance;
    }

    public function setPlantingDistance(string $plantingDistance): static
    {
        $this->plantingDistance = $plantingDistance;

        return $this;
    }

    public function getFertilizer(): ?string
    {
        return $this->fertilizer;
    }

    public function setFertilizer(string $fertilizer): static
    {
        $this->fertilizer = $fertilizer;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(string $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?string
    {
        return $this->width;
    }

    public function setWidth(string $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getFoliage(): ?string
    {
        return $this->foliage;
    }

    public function setFoliage(string $foliage): static
    {
        $this->foliage = $foliage;

        return $this;
    }

    public function getFoliageType(): ?string
    {
        return $this->foliageType;
    }

    public function setFoliageType(string $foliageType): static
    {
        $this->foliageType = $foliageType;

        return $this;
    }

    public function getShape(): ?string
    {
        return $this->shape;
    }

    public function setShape(string $shape): static
    {
        $this->shape = $shape;

        return $this;
    }

    public function getFlowers(): ?string
    {
        return $this->flowers;
    }

    public function setFlowers(string $flowers): static
    {
        $this->flowers = $flowers;

        return $this;
    }

    public function getBloomPeriod(): ?string
    {
        return $this->bloomPeriod;
    }

    public function setBloomPeriod(string $bloomPeriod): static
    {
        $this->bloomPeriod = $bloomPeriod;

        return $this;
    }

    public function getFruits(): ?string
    {
        return $this->fruits;
    }

    public function setFruits(string $fruits): static
    {
        $this->fruits = $fruits;

        return $this;
    }

    public function getToxicity(): ?string
    {
        return $this->toxicity;
    }

    public function setToxicity(string $toxicity): static
    {
        $this->toxicity = $toxicity;

        return $this;
    }

    public function getCareTips(): array
    {
        return $this->careTips;
    }

    public function setCareTips(array $careTips): static
    {
        $this->careTips = $careTips;

        return $this;
    }

    public function isSafeGuess(): ?bool
    {
        return $this->isSafeGuess;
    }

    public function setIsSafeGuess(bool $isSafeGuess): static
    {
        $this->isSafeGuess = $isSafeGuess;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
