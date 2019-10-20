<?php

namespace App\Tests\Service;

use App\Entity\Image;
use App\Exception\UnsupportedFileFormatException;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FileServiceTest extends KernelTestCase
{
    /**
     * @var string
     */
    private $testJsonFile;

    /**
     * @var string
     */
    private $testXmlFile;

    protected function setUp()
    {
        self::bootKernel();

        $projectDir = self::$kernel->getProjectDir();
        $this->testJsonFile = $projectDir . '/var/cache/test/images.json';
        $this->testXmlFile = $projectDir . '/var/cache/test/images.xml';
        parent::setUp();
    }

    public function testGenerateJsonImagesListFile(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 2; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('jsonSerialize')->willReturn([
                'id' => $i,
                'name' => 'test ' . $i,
                'imageUrl' => 'https://example.com/image' . $i . '.jpg',
                'getDiscountPercentage' => (float) $i * 5,
            ]);
            $imagesArray[] = $image;
        }

        $fileService = new FileService();
        $fileService->generateImagesListFile('json', $this->testJsonFile, $imagesArray);
        $this->assertTrue(file_exists($this->testJsonFile));
        $this->assertEquals(
            '[{"id":0,"name":"test 0","imageUrl":"https:\/\/example.com\/image0.jpg","getDiscountPercentage":0},{"id":1,"name":"test 1","imageUrl":"https:\/\/example.com\/image1.jpg","getDiscountPercentage":5}]',
            file_get_contents($this->testJsonFile)
        );
    }

    public function testGenerateXmlImagesListFile(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 2; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('getId')->willReturn($i);
            $image->method('getName')->willReturn('Test ' . $i);
            $image->method('getImageUrl')->willReturn('https://example.com/picture' . $i);
            $image->method('getDiscountPercentage')->willReturn((float)$i * 10);
            $imagesArray[] = $image;
        }

        $fileService = new FileService();
        $fileService->generateImagesListFile('xml', $this->testXmlFile, $imagesArray);
        $this->assertTrue(file_exists($this->testXmlFile));
        $this->assertEquals(
            '<?xml version="1.0"?>
<images><image0><id>0</id><name>Test 0</name><image_url>https://example.com/picture0</image_url><discount_percentage>0</discount_percentage></image0><image1><id>1</id><name>Test 1</name><image_url>https://example.com/picture1</image_url><discount_percentage>10</discount_percentage></image1></images>
',
            file_get_contents($this->testXmlFile)
        );
    }

    public function testCannotGenerateFileWithUnsupportedFormat(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 2; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('getId')->willReturn($i);
            $image->method('getName')->willReturn('Test ' . $i);
            $image->method('getImageUrl')->willReturn('https://example.com/picture' . $i);
            $image->method('getDiscountPercentage')->willReturn((float)$i * 10);
            $imagesArray[] = $image;
        }

        $this->expectException(UnsupportedFileFormatException::class);
        $this->expectExceptionMessage('Unsupported file format: pdf');

        $fileService = new FileService();
        $fileService->generateImagesListFile('pdf', $this->testXmlFile, $imagesArray);
    }
}
