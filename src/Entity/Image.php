<?php

namespace App\Entity;

use JsonSerializable;

/**
 * Class Image
 * @package App\Entity
 */
class Image implements JsonSerializable
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var float
     */
    private $discountPercentage;

    /**
     * Image constructor.
     * @param string $id
     * @param string $name
     * @param string $imageUrl
     * @param float $discountPercentage
     */
    public function __construct(string $id, string $name, string $imageUrl, float $discountPercentage)
    {
        $this->id = $id;
        $this->name = $name;
        $this->imageUrl = trim($imageUrl);
        $this->discountPercentage = $discountPercentage;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    /**
     * @return float
     */
    public function getDiscountPercentage(): float
    {
        return $this->discountPercentage;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->getName(),
            'imageUrl' => $this->getImageUrl(),
            'getDiscountPercentage' => $this->getDiscountPercentage(),
        ];
    }
}
