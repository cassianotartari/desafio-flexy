<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CalculoFreteAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('list');
        $collection->remove('edit');
        $collection->remove('delete');
        $collection->remove('show');
        $collection->remove('export');
        $collection->add('calculaFrete', 'calcula-frete');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setTemplate('edit', 'AppBundle:CalculoFrete:edit.html.twig');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('cep')
            ->add('peso')
        ;
    }
}
