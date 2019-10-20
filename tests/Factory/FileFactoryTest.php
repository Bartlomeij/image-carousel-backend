<?php

namespace App\Tests\Factory;

use App\Entity\Image;
use App\Entity\ImagesListJsonFile;
use App\Entity\ImagesListXmlFile;
use App\Exception\FileDoesNotExistException;
use App\Exception\InvalidClassTypeException;
use App\Exception\UnsupportedFileFormatException;
use App\Factory\FileFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class FileFactoryTest
 * @package App\Tests\Factory
 */
class FileFactoryTest extends KernelTestCase
{
    /**
     * @var string
     */
    private $testCsvFilePath;

    protected function setUp()
    {
        self::bootKernel();

        $projectDir = self::$kernel->getProjectDir();
        $this->testCsvFilePath = $projectDir . '/tests/_data/';
        parent::setUp();
    }

    public function testCreateAssociativeArrayFromCsvFile(): void
    {
        $array = FileFactory::createAssociativeArrayFromCsvFile($this->testCsvFilePath . 'testfile.csv');
        $this->assertEquals(5, sizeof($array));

        $this->assertEquals(4, sizeof($array[0]));
        $this->assertEquals('123', $array[0]['id']);
        $this->assertEquals('Atlantis 1 The Palm', $array[0]['name']);
        $this->assertEquals('https://via.placeholder.com/250x250', $array[0]['image']);
        $this->assertEquals(25, $array[0]['discount_percentage']);

        $this->assertEquals(4, sizeof($array[1]));
        $this->assertEquals('124', $array[1]['id']);
        $this->assertEquals('Atlantis 2 The Palm', $array[1]['name']);
        $this->assertEquals('https://via.placeholder.com/220x220', $array[1]['image']);
        $this->assertEquals(30, $array[1]['discount_percentage']);

        $this->assertEquals(4, sizeof($array[2]));
        $this->assertEquals('125', $array[2]['id']);
        $this->assertEquals('Atlantis 3 The Palm', $array[2]['name']);
        $this->assertEquals('https://via.placeholder.com/300x300', $array[2]['image']);
        $this->assertEquals(20, $array[2]['discount_percentage']);

        $this->assertEquals(4, sizeof($array[3]));
        $this->assertEquals('126', $array[3]['id']);
        $this->assertEquals('Atlantis 4 The Palm', $array[3]['name']);
        $this->assertEquals('https://via.placeholder.com/350x350', $array[3]['image']);
        $this->assertEquals(5.5, $array[3]['discount_percentage']);

        $this->assertEquals(4, sizeof($array[4]));
        $this->assertEquals('127', $array[4]['id']);
        $this->assertEquals('Atlantis 5 The Palm', $array[4]['name']);
        $this->assertEquals('https://via.placeholder.com/500x500', $array[4]['image']);
        $this->assertEquals(15, $array[4]['discount_percentage']);
    }

    public function testCreateAssociativeArrayFromCsvFileDoesNotExist(): void
    {
        $this->expectException(FileDoesNotExistException::class);
        $this->expectExceptionMessage('File ' . $this->testCsvFilePath . 'testWrongFile.csv does not exist');
        FileFactory::createAssociativeArrayFromCsvFile($this->testCsvFilePath . 'testWrongFile.csv');
    }

    public function testCreateJsonFileFromImagesArray(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 10; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('getId')->willReturn($i);
            $image->method('getName')->willReturn('Test ' . $i);
            $image->method('getImageUrl')->willReturn('https://example.com/picture' . $i);
            $image->method('getDiscountPercentage')->willReturn((float)$i * 10);
            $imagesArray[] = $image;
        }

        $jsonFile = FileFactory::createFileFromImagesArray('json', $imagesArray);
        $this->assertEquals(10, sizeof($jsonFile->getImages()));
        $this->assertInstanceOf(ImagesListJsonFile::class, $jsonFile);
        $images = $jsonFile->getImages();

        for ($i = 0; $i < 10; $i++) {
            $this->assertArrayHasKey($i, $images);
            $image = $images[$i];
            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals($i, $image->getId());
            $this->assertEquals('Test ' . $i, $image->getName());
            $this->assertEquals('https://example.com/picture' . $i, $image->getImageUrl());
            $this->assertEquals((float)$i * 10, $image->getDiscountPercentage());
        }
    }

    public function testCreateXmlFileFromImagesArray(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 10; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('getId')->willReturn($i);
            $image->method('getName')->willReturn('Test ' . $i);
            $image->method('getImageUrl')->willReturn('https://example.com/picture' . $i);
            $image->method('getDiscountPercentage')->willReturn((float)$i * 10);
            $imagesArray[] = $image;
        }

        $jsonFile = FileFactory::createFileFromImagesArray('xml', $imagesArray);
        $this->assertEquals(10, sizeof($jsonFile->getImages()));
        $this->assertInstanceOf(ImagesListXmlFile::class, $jsonFile);
        $images = $jsonFile->getImages();

        for ($i = 0; $i < 10; $i++) {
            $this->assertArrayHasKey($i, $images);
            $image = $images[$i];
            $this->assertInstanceOf(Image::class, $image);
            $this->assertEquals($i, $image->getId());
            $this->assertEquals('Test ' . $i, $image->getName());
            $this->assertEquals('https://example.com/picture' . $i, $image->getImageUrl());
            $this->assertEquals((float)$i * 10, $image->getDiscountPercentage());
        }
    }

    public function testCannotCreateFileFromImagesArrayWithNotSupportedType(): void
    {
        $imagesArray = [];
        for ($i = 0; $i < 10; $i++) {
            $image = $this->createMock(Image::class);
            $image->method('getId')->willReturn($i);
            $image->method('getName')->willReturn('Test ' . $i);
            $image->method('getImageUrl')->willReturn('https://example.com/picture' . $i);
            $image->method('getDiscountPercentage')->willReturn((float)$i * 10);
            $imagesArray[] = $image;
        }

        $this->expectException(UnsupportedFileFormatException::class);
        $this->expectExceptionMessage('Unsupported file format: pdf');
        FileFactory::createFileFromImagesArray('pdf', $imagesArray);
    }

    public function testCannotCreateFileFromImagesArrayWithWrongArray(): void
    {
        $this->expectException(InvalidClassTypeException::class);
        $this->expectExceptionMessage('Expected instance of App\Entity\Image, string passed');
        FileFactory::createFileFromImagesArray('json', ['just', 'a', 'test']);
    }

    public function testCannotCreateFileFromImagesArrayWithWrongArray2(): void
    {
        $this->expectException(InvalidClassTypeException::class);
        $this->expectExceptionMessage('Expected instance of App\Entity\Image, App\Entity\ImagesListXmlFile passed');
        FileFactory::createFileFromImagesArray('json', [new ImagesListXmlFile()]);
    }
}
