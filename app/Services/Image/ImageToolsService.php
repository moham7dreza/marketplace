<?php

namespace App\Services\Image;

class ImageToolsService
{
    protected $image;
    protected $exclusiveDirectory;
    protected $imageDirectory;
    protected $imageName;
    protected $imageFormat;
    protected $finalImageDirectory;
    protected $finalImageName;

    /**
     * @param $image
     * @return void
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function setCurrentImageName(): bool
    {
        return !empty($this->image) ? $this->setImageName(pathinfo($this->image->getClientOriginalName(), PATHINFO_FILENAME)) : false;
        // $_FILES['image']['name']
    }

    /**
     * @return mixed
     */
    public function getFinalImageName(): mixed
    {
        return $this->finalImageName;
    }

    /**
     * @param $finalImageName
     * @return void
     */
    public function setFinalImageName($finalImageName): void
    {
        $this->finalImageName = $finalImageName;
    }

    /**
     * @return string
     */
    public function getImageAddress(): string
    {
        return $this->finalImageDirectory . DIRECTORY_SEPARATOR . $this->finalImageName;
    }

    /**
     * @return void
     */
    protected function provider(): void
    {
        //set properties
            $this->getImageDirectory() ?? $this->setImageDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d'));
            $this->getImageName() ?? $this->setImageName(time());
            $this->getImageFormat() ?? $this->setImageFormat($this->image->extension());

        //set final image Directory
        $finalImageDirectory = empty($this->getExclusiveDirectory()) ? $this->getImageDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getImageDirectory();
        $this->setFinalImageDirectory($finalImageDirectory);

        //set final image name
        $this->setFinalImageName($this->getImageName() . '.' . $this->getImageFormat());

        //check adn create final image directory
        $this->checkDirectory($this->getFinalImageDirectory());
    }

    /**
     * @return mixed
     */
    public function getImageDirectory(): mixed
    {
        return $this->imageDirectory;
    }

    /**
     * @param $imageDirectory
     * @return void
     */
    public function setImageDirectory($imageDirectory): void
    {
        $this->imageDirectory = trim($imageDirectory, '/\\');
    }

    /**
     * @return mixed
     */
    public function getImageName(): mixed
    {
        return $this->imageName;
    }

    /**
     * @param $imageName
     * @return void
     */
    public function setImageName($imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @return mixed
     */
    public function getImageFormat(): mixed
    {
        return $this->imageFormat;
    }

    /**
     * @param $imageFormat
     * @return void
     */
    public function setImageFormat($imageFormat): void
    {
        $this->imageFormat = $imageFormat;
    }

    /**
     * @return mixed
     */
    public function getExclusiveDirectory(): mixed
    {
        return $this->exclusiveDirectory;
    }

    /**
     * @param $exclusiveDirectory
     * @return void
     */
    public function setExclusiveDirectory($exclusiveDirectory): void
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    /**
     * @param $imageDirectory
     * @return void
     */
    protected function checkDirectory($imageDirectory): void
    {
        if (!file_exists($imageDirectory)) {
            mkdir($imageDirectory, 0755, true);
        }
    }

    /**
     * @return mixed
     */
    public function getFinalImageDirectory(): mixed
    {
        return $this->finalImageDirectory;
    }

    /**
     * @param $finalImageDirectory
     * @return void
     */
    public function setFinalImageDirectory($finalImageDirectory): void
    {
        $this->finalImageDirectory = $finalImageDirectory;
    }
}
