<?php

namespace App\Entity;

/**
 * Class ImagesListJsonFile
 * @package App\Entity
 */
class ImagesListJsonFile extends AbstractImagesListFile
{
    /**
     * @param string $path
     */
    public function save(string $path): void
    {
        $content = $this->getContent();
        file_put_contents($path, $content);
    }

    /**
     * @return string
     */
    private function getContent(): string
    {
        return json_encode($this->getImages(), 0, 200);
    }
}
