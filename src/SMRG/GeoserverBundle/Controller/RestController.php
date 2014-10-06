<?php

namespace SMRG\GeoserverBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SMRG\GeoserverBundle\Entity\GeoJSON;
use SMRG\GeoserverBundle\Entity\GeoJSONFeature;
use SMRG\GeoserverBundle\Entity\GeoJSONLineString;
use SMRG\GeoserverBundle\Entity\Project;
use SMRG\GeoserverBundle\Entity\Track;
use SMRG\GeoserverBundle\Form\ProjectType;
use SMRG\GeoserverBundle\Form\TrackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class RestController extends FOSRestController
{
    public function getProjectsAction()
    {
        $projects = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->findAll();
        $view = $this->view($projects, 200)
            ->setTemplate("SMRGGeoserverBundle:Rest:getProjects.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);

    }

    public function getProjectAction($id)
    {
        $project = $this->getDoctrine()->getRepository('SMRG\GeoserverBundle\Entity\Project')->getWithRelated($id);

        if (!$project instanceof Project) {
            throw new NotFoundHttpException('Project not found');
        }

        $view = $this->view($project, 200)
            ->setTemplate("SMRGGeoserverBundle:Rest:getProjects.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);
    }

    public function getTracksAction()
    {
        $projects = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->findAll();
        $view = $this->view($projects, 200)
            ->setTemplate("SMRGGeoserverBundle:Rest:getTrack.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);

    }

    public function getTrackAction($id)
    {
        $project = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->find($id);

        if (!$project instanceof Track) {
            throw new NotFoundHttpException('Track not found');
        }

        $view = $this->view($project, 200)
            ->setTemplate("SMRGGeoserverBundle:Rest:getTracks.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);
    }

    public function getGeoJsonAction()
    {

        $projects = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->findAll();
        $geoJSON = array();
        foreach ($projects as $key => $project) {


            foreach ($project->getTracks() as $track) {

                /* @var Track $track */
                if (is_null($track->getGpxFile())) {
                    continue;
                }

                $xml = simplexml_load_file('/var/www/geoserver/web/uploads/tracks/' . $track->getGpxFile());

                $linestring = new GeoJSONLineString(array());
                foreach ($xml->trk->trkseg->trkpt as $segment) {
                    $linestring->addCoordinate(array((float)$segment->attributes()->lon, (float)$segment->attributes()->lat));
                    $linestring->rating = $track->getRating();
                    $properties = new GeoJSONFeature();
                    $properties->name = $track->getName();
                    $properties->popupContent = '<br>Rating: ' . $track->getRating();
                    $linestring->properties = $properties;

                }

                $geoJSON[] = $linestring;
            }
        }

        $view = $this->view($geoJSON, 200)
            ->setTemplate("SMRGGeoserverBundle:Rest:getTracks.html.twig")
            ->setTemplateVar('data')
            ->setFormat('json');

        return $this->handleView($view);
    }


    public function newProjectAction(Request $request)
    {
        return $this->processProjectForm(new Project(), $request);
    }

    protected function processProjectForm(Project $project, Request $request)
    {

        $statusCode = !$project->getId() ? 201 : 204;

        $form = $this->createForm(new ProjectType(), $project);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward('SMRGGeoserverBundle:Rest:getProject', array(
                    'id' => $project->getId()
                ));


                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)
            ->setTemplate("SMRGGeoserverBundle:Rest:getProjects.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);
    }

    public function newTrackAction(Request $request)
    {
        return $this->processTrackForm(new Track(), $request);
    }

    protected function processTrackForm(Track $track, Request $request)
    {

        $statusCode = !$track->getId() ? 201 : 204;

        $form = $this->createForm(new TrackType(), $track);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($track);
            $em->flush();

            $track->upload();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward('SMRGGeoserverBundle:Rest:getTrack', array(
                    'id' => $track->getId()
                ));


                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)
            ->setTemplate("SMRGGeoserverBundle:Rest:getProjects.html.twig")
            ->setTemplateVar('data')
            ->setFormat('xml');

        return $this->handleView($view);
    }

    public function redirectAction()
    {

        $view = $this->routeRedirectView('some_route', array(), 301);

        return $this->handleView($view);
    }

}
