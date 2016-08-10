<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 10.08.16
 * Time: 19:14
 */

namespace AppBundle\Service;


use AppBundle\Entity\Directory;
use AppBundle\Entity\File;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\VarDumper\VarDumper;

class FileService
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var string
     */
    protected $uploadDir;

    public function __construct($entityManager, $uploadDir)
    {
        $this->em = $entityManager;
        $this->uploadDir = $uploadDir;
    }

    /**
     * Create a new file
     *
     * @param UploadedFile $UploadedFile
     * @param Directory|null $directory
     * @return File|bool
     */
    public function create($UploadedFile, Directory $directory = null)
    {
        $file = new File();

        $file->setName($UploadedFile->getClientOriginalName())
            ->setHash(md5($UploadedFile->getFilename()))
            ->setSize($UploadedFile->getSize())
            ->setDirectory($directory)
        ;

        $UploadedFile->move(
            $this->uploadDir,
            $file->getHash()
        );
        try {
            $this->em->persist($file);
            $this->em->flush();
        } catch (\Exception $e) {
            // @todo log exception
            return false;
        }

        return $file;
    }

    /**
     *
     * Edit file name
     * @param File $edit
     * @param string $newName
     * @return bool
     */
    public function edit($edit, $newName)
    {
        $edit->setName($newName);

        try {
            $this->em->persist($edit);
            $this->em->flush();
        } catch (\Exception $e) {
            // @todo log exception
            return false;
        }

        return true;
    }

}