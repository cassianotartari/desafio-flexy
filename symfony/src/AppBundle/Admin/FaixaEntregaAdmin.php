<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FaixaEntregaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('transportadora')
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
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('transportadora')
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
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('transportadora')
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
            ->add('updatedAt')
            ->add('createdAt')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        //somente adicionar o campo transportadora no admin dela
        //para utilizar no inline form de cadastro de transportadora ele não é adicionado
        if ($this->getRoot()->getClass() == get_class($this->getSubject()))
        {
            $formMapper->add('transportadora');
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

}
