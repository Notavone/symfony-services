<?php
/*
 * Copyright (c) 2021 Léo Hugonnot.
 */

namespace App\Service;


use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileUploader
 * @package App\Service
 */
class FileUploader
{
    /**
     * @var string
     */
    private $targetDirectory;

    /**
     * @var string
     */
    private $prefix;

    /**
     * Creates a FileUploader linked to the target directory
     * @param string $targetDirectory targeted directory
     * @param string $prefix string to prepend to all files created by this FileUploader
     */
    public function __construct(string $targetDirectory = "", string $prefix = "")
    {
        $this->targetDirectory = $targetDirectory;
        $this->prefix = $prefix;
    }


    /**
     * @param UploadedFile $file uploaded file
     * @param string $name name of the file
     * @return string the file's name on the system
     * @throws FileException if it can not upload the file
     */
    public function upload(UploadedFile $file, string $name): string
    {
        $fileName = $this->prefix . $name . '.' . $file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (FileException $exception) {
            throw $exception;
        }

        return $fileName;
    }

    /**
     * @param string $name the name of the file to unlink in the targeted directory
     * @throws Exception if it can not unlink the file
     */
    public function unlink(string $name): void
    {
        $filePath = $this->targetDirectory . '/' . $name;
        try {
            $this->unlink($filePath);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @return string
     */
    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    /**
     * @param string $targetDirectory
     */
    public function setTargetDirectory(string $targetDirectory): void
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }


}