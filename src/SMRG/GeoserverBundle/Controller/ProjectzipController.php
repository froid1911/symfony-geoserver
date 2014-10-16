<?php

namespace SMRG\GeoserverBundle\Controller;

use SMRG\GeoserverBundle\Form\ProjectzipType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectzipController extends Controller
{
    public function newAction()
    {

        $form = $this->createForm(new ProjectzipType(), null, array(
            'action' => $this->generateUrl('form_project_zip_decompress'),
            'method' => 'POST'
        ));

        $form->add('submit', 'submit', array('label' => 'Zip hochladen'));

        return $this->render('SMRGGeoserverBundle:Projectzip:new.html.twig', array('form' => $form->createView()));
    }

    public function decompressAction()
    {

        /* @TODO: decompress Zip File */
        /* @var Request $request */
        $request = $this->get('request');

        $form = $this->createForm(new ProjectzipType());
        $form->handleRequest($request);

        if ($form->isValid()) {
//            var_dump($form->getData());
        }

//
//        /* @var FileBag $files */
//        $files = $this->get('request')->files;
//
//        /* @var UploadedFile $file */
//        $file = $files->all()['smrg_geoserverbundle_projectzip']['file'];
//
//        // Move to ZIP Dir
////        $file->move();
//
//        // Decompress
//        // Read XML
//        // create Project with tracks and events


    }
}
