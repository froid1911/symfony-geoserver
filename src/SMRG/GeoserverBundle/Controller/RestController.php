<?php

namespace SMRG\GeoserverBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SMRG\GeoserverBundle\Entity\Event;
use SMRG\GeoserverBundle\Entity\EventCategory;
use SMRG\GeoserverBundle\Entity\GeoJSONFeature;
use SMRG\GeoserverBundle\Entity\GeoJSONLineString;
use SMRG\GeoserverBundle\Entity\Project;
use SMRG\GeoserverBundle\Entity\Track;
use SMRG\GeoserverBundle\Entity\TrackPicture;
use SMRG\GeoserverBundle\Form\Type\EventCategoryType;
use SMRG\GeoserverBundle\Form\Type\ProjectType;
use SMRG\GeoserverBundle\Form\Type\TrackPictureType;
use SMRG\GeoserverBundle\Form\Type\TrackType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestController extends FOSRestController
{

    /**
     * @ApiDoc(
     *  description="Return a Project",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="ID of Project to return"
     *      }
     *  },
     *  section="Project"
     * )
     */
    public function getProjectAction($id)
    {
        $project = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->find($id);

        if (!$project instanceof Project) {
            throw new NotFoundHttpException('Project not found');
        }

        $view = $this->view($project, 200)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    protected function getFormat()
    {

        return $this->get('request')->get('format') ? $this->get('request')->get('format') : 'json';

    }


    /**
     * @ApiDoc(
     *  description="Returns a collection of Projects",
     *  section="Project",
     *  statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the Projects are not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getProjectsAction()
    {
        $projects = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->findAll();

        $view = $this->view($projects, 200)->setFormat($this->getFormat());

        return $this->handleView($view);

    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of Events",
     *  section="Event",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the Events are not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getEventsAction()
    {
        $events = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Event')->findAll();

        $view = $this->view($events, 200)->setFormat($this->getFormat());

        return $this->handleView($view);

    }

    /**
     * @ApiDoc(
     *  description="Deletes an Event",
     *  section="Event",
     *
     * )
     */
    public function deleteEventAction($id)
    {
        $event = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Event')->find($id);

        if (!$event instanceof Event) {
            throw new NotFoundHttpException('Event not found');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($event);
        $manager->flush();

        return new Response('');

    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of EventCategories",
     *  section="EventCategory",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getEventcategoriesAction()
    {
        $eventcategories = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:EventCategory')->findAll();

        $view = $this->view($eventcategories, 200)->setFormat($this->getFormat());

        return $this->handleView($view);

    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of Tracks",
     *  section="Track",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getTracksAction()
    {
        $projects = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->findAll();
        $view = $this->view($projects, 200)->setFormat($this->getFormat());

        return $this->handleView($view);

    }

    /**
     * @ApiDoc(
     *  description="Returns an Track",
     *  section="Track",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getTrackAction($id)
    {
        $track = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->find($id);

        if (!$track instanceof Track) {
            throw new NotFoundHttpException('Track not found');
        }

        $view = $this->view($track, 200)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Creates a new Project",
     *  section="Project",
     *  input="SMRG\GeoserverBundle\Form\ProjectType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function newProjectAction()
    {
        return $this->processProjectForm(new Project());
    }

    protected function processProjectForm(Project $project)
    {
        $request = $this->get('request');

        $statusCode = !$project->getId() ? 201 : 204;

        $form = $this->createForm(new ProjectType(), $project, array('method' => $request->getMethod()));
        $form->handleRequest($request);
//        var_dump($request->);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);
            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward(
                    'SMRGGeoserverBundle:Rest:getProject',
                    array(
                        'id' => $project->getId()
                    )
                );


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

    /**
     * @ApiDoc(
     *  description="Delete a Project",
     *  section="Project"
     * )
     */
    public function deleteProjectAction($id)
    {
        $project = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->find($id);

        if (!$project instanceof Project) {
            throw new NotFoundHttpException('Project not found');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($project);
        $manager->flush();

        return new Response('');

    }

    /**
     * @ApiDoc(
     *  description="Delete a Track",
     *  section="Track"
     * )
     */
    public function deleteTrackAction($id)
    {
        $track = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->find($id);

        if (!$track instanceof Track) {
            throw new NotFoundHttpException('Track not found');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($track);
        $manager->flush();

        return new Response('');

    }

    /**
     * @ApiDoc(
     *  description="Update an Event",
     *  section="Event",
     *  input="SMRG\GeoserverBundle\Form\EventType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function updateEventAction($id)
    {
        $event = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Event')->find($id);
        if (!$event instanceof Event) {
            throw new NotFoundHttpException('Event not found');
        }

        return $this->processEventForm($event);
    }

    protected function processEventForm(Event $event)
    {
        $statusCode = !$event->getId() ? 201 : 204;

        $request = $this->get('request');

        $form = $this->createForm(new EventType(), $event, array('method' => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward(
                    'SMRGGeoserverBundle:Rest:getEvent',
                    array(
                        'id' => $event->getId()
                    )
                );

                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Update an Project",
     *  section="Project",
     *  input="SMRG\GeoserverBundle\Form\ProjectType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function updateProjectAction($id)
    {

        $project = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Project')->find($id);
        if (!$project instanceof Project) {
            throw new NotFoundHttpException('Project not found');
        }

        return $this->processProjectForm($project);

    }

    /**
     * @ApiDoc(
     *  description="Update an EventCategory",
     *  section="EventCategory",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function updateEventcategoryAction($id)
    {
        $eventcategory = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:EventCategory')->find($id);
        if (!$eventcategory instanceof EventCategory) {
            throw new NotFoundHttpException('Event Category not found');
        }

        return $this->processEventcategoryForm($eventcategory);
    }

    protected function processEventcategoryForm(EventCategory $eventCategory)
    {
        $statusCode = !$eventCategory->getId() ? 201 : 204;

        $request = $this->get('request');

        $form = $this->createForm(new EventCategoryType(), $eventCategory, array('method' => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($eventCategory);
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward(
                    'SMRGGeoserverBundle:Rest:getEventcategory',
                    array(
                        'id' => $eventCategory->getId()
                    )
                );

                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Update an Track",
     *  section="Track",
     *  input="SMRG\GeoserverBundle\Form\TrackType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function updateTrackAction($id)
    {
        $track = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Track')->find($id);
        if (!$track instanceof Track) {
            throw new NotFoundHttpException('Track not found');
        }

        return $this->processTrackForm($track);
    }

    protected function processTrackForm(Track $track)
    {
        $statusCode = !$track->getId() ? 201 : 204;
        $request = $this->get('request');

        $form = $this->createForm(new TrackType(), $track, array('method' => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $track->upload();

            $em->persist($track);
            $em->flush();


            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward(
                    'SMRGGeoserverBundle:Rest:getTrack',
                    array(
                        'id' => $track->getId()
                    )
                );


                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Delete an EventCategory",
     *  section="EventCategory",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function deleteEventcategoryAction($id)
    {
        $eventcategory = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:EventCategory')->find($id);

        if (!$eventcategory instanceof EventCategory) {
            throw new NotFoundHttpException('Event not found');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($eventcategory);
        $manager->flush();

        return new Response('');

    }

    /**
     * @ApiDoc(
     *  description="Create a new Track",
     *  section="Track",
     *  input="SMRG\GeoserverBundle\Form\TrackType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function newTrackAction()
    {
        return $this->processTrackForm(new Track());
    }

    /**
     * @ApiDoc(
     *  description="Create a new Event",
     *  section="Event",
     *  input="SMRG\GeoserverBundle\Form\EventType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function newEventAction()
    {
        return $this->processTrackForm(new Event());
    }


    /**
     * @ApiDoc(
     *  description="Get an Event",
     *  section="Event",
     *  input="Integer",
     *  output="SMRG\GeoserverBundle\Event",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getEventAction($id)
    {
        $event = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:Event')->find($id);

        if (!$event instanceof Event) {
            throw new NotFoundHttpException('Event not found');
        }

        $view = $this->view($event, 200)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Create a new EventCategory",
     *  section="EventCategory",
     *  input="SMRG\GeoserverBundle\Form\EventCategoryType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function newEventcategoryAction()
    {
        return $this->processEventcategoryForm(new EventCategory());
    }

    /**
     * @ApiDoc(
     *  description="Get an EventCategory",
     *  section="EventCategory",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     *
     * )
     */
    public function getEventcategoryAction($id)
    {
        $eventCategory = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:EventCategory')->find($id);

        if (!$eventCategory instanceof EventCategory) {
            throw new NotFoundHttpException('EventCategory not found');
        }

        $view = $this->view($eventCategory, 200)->setFormat($this->getFormat());

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

                $xml = simplexml_load_file(__DIR__ . '/../../../../web/uploads/tracks/' . $track->getGpxFile());
                $content = $this->getTrackContent($track);
                $linestring = new GeoJSONLineString(array());
                foreach ($xml->trk->trkseg->trkpt as $segment) {
                    $linestring->addCoordinate(
                        array((float)$segment->attributes()->lon, (float)$segment->attributes()->lat)
                    );
                    $linestring->rating = $track->getRating();
                    $properties = new GeoJSONFeature();
                    $properties->name = $track->getName();
                    $properties->popupContent = $content;
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

    protected function getTrackContent(Track $track)
    {

        $content = 'Rating: ' . $track->getRating() .
            '<hr>';
        $request = $this->get('request');

        if (is_object($track->getPictures()->first())) {
            $content .= '<img src="' . $request->getBasePath() .
                '/uploads/images/' . $track->getPictures()->first()->getPath() .
                '" width="300">';
        }

        if (count($track->getAttributes()) > 0) {
            $content .= '<hr>';
            foreach ($track->getAttributes() as $key => $attribute) {
                $content .= '<br />' . ucfirst($key) . ': ' . $attribute;
            }
        }

        return $content;
    }

    /**
     * @ApiDoc(
     *  description="Create a new TrackPicture",
     *  section="TrackPicture",
     *  input="SMRG\GeoserverBundle\Form\TrackPictureType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function newTrackpictureAction()
    {
        return $this->processTrackpicturesForm(new TrackPicture());
    }

    protected function processTrackpicturesForm(TrackPicture $trackpicture)
    {
        $statusCode = !$trackpicture->getId() ? 201 : 204;
        $request = $this->get('request');

        $form = $this->createForm(new TrackPictureType(), $trackpicture, array('method' => $request->getMethod()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $trackpicture->upload();

            $em->persist($trackpicture);
            $em->flush();


            $response = new Response();
            $response->setStatusCode($statusCode);

            // set the `Location` header only when creating new resources
            if (201 === $statusCode) {

                $response = $this->forward(
                    'SMRGGeoserverBundle:Rest:getTrackpicture',
                    array(
                        'id' => $trackpicture->getId()
                    )
                );


                return $response;

            }

            return $response;
        }

        $view = $this->view($form, 400)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Get an TrackPicture",
     *  section="TrackPicture",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     *
     * )
     */
    public function getTrackpictureAction($id)
    {
        $trackpicture = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:TrackPicture')->find($id);

        if (!$trackpicture instanceof TrackPicture) {
            throw new NotFoundHttpException('TrackPicture not found');
        }

        $view = $this->view($trackpicture, 200)->setFormat($this->getFormat());

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *  description="Update an TrackPicture",
     *  section="TrackPicture",
     *  input="SMRG\GeoserverBundle\Form\TrackPictureType",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the user is not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function updateTrackPictureAction($id)
    {
        $trackpicture = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:TrackPicture')->find($id);
        if (!$trackpicture instanceof TrackPicture) {
            throw new NotFoundHttpException('TrackPicture not found');
        }

        return $this->processTrackpicturesForm($trackpicture);
    }

    /**
     * @ApiDoc(
     *  description="Deletes an TrackPicture",
     *  section="TrackPicture",
     *
     * )
     */
    public function deleteTrackpictureAction($id)
    {
        $trackpicture = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:TrackPicture')->find($id);

        if (!$trackpicture instanceof TrackPicture) {
            throw new NotFoundHttpException('TrackPicture not found');
        }

        $manager = $this->getDoctrine()->getManager();

        $manager->remove($trackpicture);
        $manager->flush();

        return new Response('');

    }

    /**
     * @ApiDoc(
     *  description="Returns a collection of TrackPictures",
     *  section="TrackPicture",
     * statusCodes={
     *         200="Returned when successful",
     *         403="Returned when the user is not authorized to say hello",
     *         404={
     *           "Returned when the Events are not found",
     *           "Returned when something else is not found"
     *         }
     *     }
     * )
     */
    public function getTrackpicturesAction()
    {
        $trackpictures = $this->getDoctrine()->getRepository('SMRGGeoserverBundle:TrackPicture')->findAll();

        $view = $this->view($trackpictures, 200)->setFormat($this->getFormat());

        return $this->handleView($view);

    }

}
