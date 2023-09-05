<?php

namespace App\Traits;

use App\Services\Image\ImageService;

trait FileUploadTrait
{
    // File upload
    /******************************************************************************************************************/
    /**
     * @param string $directoryName
     * @param $file
     * @param $fileService
     * @param string $saveLocation
     * @return array
     */
    public static function saveFileAndMove(string $directoryName, $file, $fileService, string $saveLocation = 'public'): array
    {
        $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . $directoryName);
        $fileService->setFileSize($file);
        $fileSize = $fileService->getFileSize();
        if ($saveLocation = 'public') {
            $result = $fileService->moveToPublic($file);
        } elseif ($saveLocation = 'storage') {
            $result = $fileService->moveToStorage($file);
        } else {
            $result = null;
        }
        $fileFormat = $fileService->getFileFormat();
        return [$result, $fileSize, $fileFormat];
    }

    // Image intervention
    /******************************************************************************************************************/
    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $imageService
     * @return mixed
     */
    public static function saveImage(string $directoryName, $imageFile, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->save($imageFile);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param ImageService $imageService
     * @return mixed
     */
    public static function createIndexAndSaveImage(string $directoryName, $imageFile, ImageService $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->createIndexAndSave($imageFile);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $width
     * @param $height
     * @param $imageService
     * @return mixed
     */
    public static function fitAndSaveImage(string $directoryName, $imageFile, $width, $height, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        return $imageService->fitAndSave($imageFile, $width, $height);
    }

    /**
     * @param string $directoryName
     * @param $imageFile
     * @param $imageName
     * @param $imageService
     * @return mixed
     */
    public static function saveImageWithName(string $directoryName, $imageFile, $imageName, $imageService): mixed
    {
        $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . $directoryName);
        $imageService->setImageName($imageName);
        return $imageService->save($imageFile);
    }

    // image uploads
    /******************************************************************************************************************/

    /**
     * @param $request
     * @param $imageService
     * @param $folderName
     * @param string $imageName
     * @param string $uploadFunctionName
     * @return string|null
     */
    public static function uploadImageOfModel($request, $imageService, $folderName,
                                              string $imageName = 'image', string $uploadFunctionName = 'saveImage'): ?string
    {
        if ($request->hasFile($imageName)) {
            $result = self::$uploadFunctionName($folderName, $request->file($imageName), $imageService);
            if (!$result) {
                return 'upload failed';
            }
            $request->image = $result;
        } else {
            $request->image = null;
        }
        return $request->image;
    }
}
