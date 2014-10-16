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


        /* @var Request $request */
        $request = $this->get('request');

        $form = $this->createForm(new ProjectzipType());
        $form->handleRequest($request);



    }
}
