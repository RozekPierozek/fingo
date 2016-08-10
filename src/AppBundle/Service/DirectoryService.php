<?php
/**
 * Created by PhpStorm.
 * User: maciej
 * Date: 10.08.16
 * Time: 19:14
 */

namespace AppBundle\Service;


use AppBundle\Entity\Directory;
use Doctrine\ORM\EntityManager;

class DirectoryService
{

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct($entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Create a new directory
     *
     * @param string $name
     * @param Directory $parent
     * @return Directory|bool
     */
    public function create($name, Directory $parent = null)
    {
        $directory = new Directory();
        $directory->setName($name)
            ->setParent($parent);

        try {
            $this->em->persist($directory);
            $this->em->flush();
        } catch (\Exception $e) {
            // @todo log exception
            return false;
        }

        return $directory;
    }

    /**
     * @param Directory $directory
     * @param string $newName
     * @return bool
     */
    public function edit($directory, $newName)
    {
        $directory->setName($newName);

        try {
            $this->em->persist($directory);
            $this->em->flush();
        } catch (\Exception $e) {
            // @todo log exception
            return false;
        }

        return true;
    }

}