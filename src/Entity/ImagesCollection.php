<?php


namespace App\Entity;


class ImagesCollection
{
    /**
     * @var array
     */
    private $images = [];

    /**
     * @param Image $image
     */
    public function addImage(Image $image): void
    {
        $this->images[] = $image;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return sizeof($this->images);
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->images;
    }
}
