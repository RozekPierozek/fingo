<?php

namespace AppBundle\Controller;

use AppBundle\Entity\File;
use AppBundle\Form\FileEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class FileController extends Controller
{

    /**
     * Action to download file
     *
     * @param Request $request
     * @param File $file
     * @return BinaryFileResponse
     */
    public function getAction(Request $request, File $file)
    {
        // @fixme fix download filename
        return new BinaryFileResponse($this->getParameter('upload_dir') . DIRECTORY_SEPARATOR . $file->getHash());
    }

    /**
     * Action to edit file name
     *
     * @param Request $request
     * @param File|null $file
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, File $file = null)
    {
        $form = $this->createForm(FileEditType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->getData();

            $this->get('app.files')->edit($file, $file->getName());

            return $this->redirectToRoute('app_directory_list', [
                'directory' => ($file->getDirectory()) ? $file->getDirectory()->getId() : null
            ]);
        }
        return $this->render('@App/file/edit.html.twig', [
            'fileForm' => $form->createView(),
        ]);
    }
}
