<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Directory;
use AppBundle\Form\DirectoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DirectoryController extends Controller
{
    /**
     * Action to list directories, subdirectroeis and files in current directory
     *
     * @param Request $request
     * @param Directory|null $directory
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function listAction(Request $request, Directory $directory = null)
    {

        if ($directory) {
            $directories = $directory->getSubDirectores();
        } else {
            $directories = $this->getDoctrine()->getRepository('AppBundle:Directory')->findBy(['parent' => null]);
        }

        /** @var Directory $newDirectory */
        $newDirectory = new Directory();

        $form = $this->createForm(DirectoryType::class, $newDirectory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newDirectory = $form->getData();
            $this->get('app.directory')->create($newDirectory->getName(), $directory);
            return $this->redirectToRoute('app_directory_list', [
                'directory' => ($directory) ? $directory->getId() : null
            ]);
        }

        return $this->render('@App/index.html.twig', [
            'directory' => $directory,
            'directoryForm' => $form->createView(),
            'directories' => $directories
        ]);
    }

    /**
     * Action to edit directory name
     *
     * @param Request $request
     * @param Directory|null $directory
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Directory $directory = null){
        $form = $this->createForm(DirectoryType::class, $directory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $directory = $form->getData();

            $this->get('app.directory')->edit($directory, $directory->getName());

            return $this->redirectToRoute('app_directory_list', [
                'directory' => ($directory) ? $directory->getId() : null
            ]);
        }
        return $this->render('@App/directory/edit.html.twig', [
            'directoryForm' => $form->createView(),
        ]);
    }
}
