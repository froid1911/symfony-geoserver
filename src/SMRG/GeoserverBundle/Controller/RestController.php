<?php

namespace SMRG\GeoserverBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use SMRG\GeoserverBundle\Entity\Project;
use SMRG\GeoserverBundle\Form\ProjectType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;


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
                $response->getHeaders()->set('Location',
                    $this->generateUrl(
                        'api_get_project', array('id' => $project->getId()),
                        true // absolute
                    )
                );
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
