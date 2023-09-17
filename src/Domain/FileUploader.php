<?php
declare(strict_types=1);

namespace App\Domain;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private const MAX_WIDTH = 1600;
    private const MAX_HEIGHT = 1067;

    private string $targetDirectory;

    private SluggerInterface $slugger;

    private Imagine $imagine;

    public function __construct(
        string $targetDirectory,
        SluggerInterface $slugger
    ) {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
        $this->imagine = new Imagine();
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (FileException $e) {
            throw $e;
        }

        return $fileName;
    }

    public function uploadWithResize(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (FileException $e) {
            throw $e;
        }

        $filename2 = $this->targetDirectory . $fileName;

        list($iwidth, $iheight) = getimagesize($filename2);
        $ratio = $iwidth / $iheight;
        $width = self::MAX_WIDTH;
        $height = self::MAX_HEIGHT;
        if ($width / $height > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        $photo = $this->imagine->open($filename2);
        $photo->resize(new Box($width, $height))->save($filename2);

        return $fileName;
    }
}
