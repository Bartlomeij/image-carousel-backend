<?php

namespace App\Filter;

use App\Entity\Image;

/**
 * Class ImagesCollectionFilter
 * @package App\Filter
 */
class ImagesCollectionFilter
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var float|null
     */
    private $discountPercentageFrom;

    /**
     * @var float|null
     */
    private $discountPercentageTo;

    /**
     * ImagesCollectionFilter constructor.
     * @param string|null $name
     * @param float|null $discountPercentageFrom
     * @param float|null $discountPercentageTo
     */
    public function __construct(
        ?string $name = null,
        ?float $discountPercentageFrom = null,
        ?float $discountPercentageTo = null
    ) {
        $this->name = $name;
        $this->discountPercentageFrom = $discountPercentageFrom;
        $this->discountPercentageTo = $discountPercentageTo;
    }

    /**
     * @param Image $image
     * @return bool
     */
    public function meetsRequirements(Image $image): bool
    {
        return $this->validateName($image) && $this->validateDiscountPercentage($image);
    }

    /**
     * @param Image $image
     * @return bool
     */
    private function validateName(Image $image): bool
    {
        return !($this->name && strpos(strtolower($image->getName()), strtolower($this->name)) === false);
    }

    /**
     * @param Image $image
     * @return bool
     */
    private function validateDiscountPercentage(Image $image): bool
    {
        if ($this->discountPercentageFrom && $image->getDiscountPercentage() < $this->discountPercentageFrom) {
            return false;
        }

        if ($this->discountPercentageTo && $image->getDiscountPercentage() > $this->discountPercentageTo) {
            return false;
        }
        return true;
    }
}
