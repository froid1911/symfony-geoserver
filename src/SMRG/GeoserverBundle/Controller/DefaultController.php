<?php

namespace SMRG\GeoserverBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SMRGGeoserverBundle:Default:index.html.twig', array('name' => "blabla"));
    }

    public function userAction()
    {
        return $this->render('SMRGGeoserverBundle:Default:user.html.twig');
    }
}
