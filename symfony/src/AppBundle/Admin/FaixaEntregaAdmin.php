<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FaixaEntregaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nome')
            ->add('cepInicial')
            ->add('cepFinal')
            ->add('pesoInicial')
            ->add('pesoFinal')
            ->add('valorQuilo')
            ->add('valorQuiloAdicional')
            ->add('prazoEntregaInicial')
            ->add('prazoEntregaFinal')
            ->add('prazoEntregaAdicionalPorPeso')
            ->add('pesoParaPrazoAdicional')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nome')
            ->add('cepInicial')
            ->add('cepFinal')
            ->add('pesoInicial')
            ->add('pesoFinal')
            ->add('valorQuilo')
            ->add('valorQuiloAdicional')
            ->add('prazoEntregaInicial')
            ->add('prazoEntregaFinal')
            ->add('prazoEntregaAdicionalPorPeso')
            ->add('pesoParaPrazoAdicional')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRoot()->getClass() == get_class($this->getSubject()))
        {
            $formMapper->add('transportadora', 'sonata_type_model_list');
        }
        $formMapper
            ->add('nome')
            ->add('cepInicial')
            ->add('cepFinal')
            ->add('pesoInicial')
            ->add('pesoFinal')
            ->add('valorQuilo', 'money', array('currency' => 'BRL', 'grouping' => true, 'required' => false))
            ->add('valorQuiloAdicional', 'money', array('currency' => 'BRL', 'grouping' => true, 'required' => false))
            ->add('prazoEntregaInicial')
            ->add('prazoEntregaFinal')
            ->add('prazoEntregaAdicionalPorPeso')
            ->add('pesoParaPrazoAdicional')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nome')
            ->add('cepInicial')
            ->add('cepFinal')
            ->add('pesoInicial')
            ->add('pesoFinal')
            ->add('valorQuilo')
            ->add('valorQuiloAdicional')
            ->add('prazoEntregaInicial')
            ->add('prazoEntregaFinal')
            ->add('prazoEntregaAdicionalPorPeso')
            ->add('pesoParaPrazoAdicional')
        ;
    }
}
