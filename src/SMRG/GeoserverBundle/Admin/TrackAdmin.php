<?php

namespace SMRG\GeoserverBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TrackAdmin extends Admin
{
    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('project')
            ->add('name')
            ->add('rating')
            ->add('gpxfile')
            ->add('attributes');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('project')
            ->add('name')
            ->add('rating')
            ->add('gpxfile')
            ->add('attributes')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('project', 'sonata_type_model', array('property' => 'name'))
            ->add('name')
            ->add('rating')
            ->add('gpxfile')
            ->add('attributes');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('project')
            ->add('name')
            ->add('rating')
            ->add('gpxfile')
            ->add('attributes');
    }
}
