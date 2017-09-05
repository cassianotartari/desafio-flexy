<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class CepNoIntervaloValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * 
     * @param \AppBundle\Entity\FaixaEntrega $faixaEntrega
     * @param Constraint $constraint
     * @return type
     */
    public function validate($faixaEntrega, Constraint $constraint)
    {
        $faixaEntregaAntiga = $this->em
            ->getUnitOfWork()
            ->getOriginalEntityData($faixaEntrega);
        
        
        /* @var $repositorio \AppBundle\Repository\FaixaEntregaRepository */
        $repositorio = $this->em->getRepository('AppBundle:FaixaEntrega');
        
        //se não tem faixa entrega antiga então estamos no create de uma faixa de entrega
        if (empty($faixaEntregaAntiga)) {
            $cep = $faixaEntrega->getCepInicial();
            /* @var $queryCepInicial \Doctrine\ORM\QueryBuilder */
            $queryCepInicial = $repositorio->verificaFaixasConflitantesPorCepUnico($cep, $faixaEntrega->getTransportadora());
            
            $this->adicionaViolacaoDoCep(
                $queryCepInicial
                , $constraint->message
                , 'cepInicial'
                , $cep
            );

            $cep = $faixaEntrega->getCepFinal();
            /* @var $queryCepFinal \Doctrine\ORM\QueryBuilder */
            $queryCepFinal = $repositorio->verificaFaixasConflitantesPorCepUnico($cep, $faixaEntrega->getTransportadora());

            $this->adicionaViolacaoDoCep(
                $queryCepFinal
                , $constraint->message
                , 'cepFinal'
                , $cep
            );
            
            
            /* @var $query \Doctrine\ORM\QueryBuilder */
            $query = $repositorio->verificaFaixasConflitantesPorCeps(
                $faixaEntrega->getCepInicial()
                , $faixaEntrega->getCepFinal()
                , $faixaEntrega->getTransportadora()
            );
            
            $result = $query->getQuery()->getResult();
            if(count($result)) {
                //adiciona erro na classe
                $this->context
                    ->buildViolation('cepinicial_cepfinal_no_intervalo')
                    ->setParameter("%cepinicial%", $faixaEntrega->getCepInicial())
                    ->setParameter("%cepfinal%", $faixaEntrega->getCepFinal())
                    ->addViolation();
            }
            return;
        }
        
        //daqui pra baixo é pro update
        
        //se cep inicial e cep final novo e antigo forem iguais não precisa validar
        if($faixaEntrega->getCepInicial() == $faixaEntregaAntiga['cepInicial'] && $faixaEntrega->getCepFinal() == $faixaEntregaAntiga['cepFinal']) {
            return;
        }

        $cep = $faixaEntrega->getCepInicial();
        
        if($cep != $faixaEntregaAntiga['cepInicial']) {
            /* @var $queryCepInicial \Doctrine\ORM\QueryBuilder */
            $queryCepInicial = $repositorio->verificaFaixasConflitantesPorCepUnicoExcluindoASi($cep, $faixaEntrega);

            $this->adicionaViolacaoDoCep(
                $queryCepInicial
                , $constraint->message
                , 'cepIncial'
                , $cep
            );
        }
        
        $cep = $faixaEntrega->getCepFinal();
        
        if($cep != $faixaEntregaAntiga['cepFinal']) {
            /* @var $queryCepInicial \Doctrine\ORM\QueryBuilder */
            $queryCepFinal = $repositorio->verificaFaixasConflitantesPorCepUnicoExcluindoASi($cep, $faixaEntrega);
        
            $this->adicionaViolacaoDoCep(
                $queryCepFinal
                , $constraint->message
                , 'cepFinal'
                , $cep
            );
        }
        if($cep != $faixaEntregaAntiga['cepFinal'] && $cep != $faixaEntregaAntiga['cepInicial']) {
            /* @var $query \Doctrine\ORM\QueryBuilder */
            $query = $repositorio->verificaFaixasConflitantesPorCepsExcluindoASi(
                $faixaEntrega->getCepInicial()
                , $faixaEntrega->getCepFinal()
                , $faixaEntrega
            );
            
            $result = $query->getQuery()->getResult();
            if(count($result)) {
                //adiciona erro na classe
                $this->context
                    ->buildViolation('cepinicial_cepfinal_no_intervalo')
                    ->setParameter("%cepinicial%", $faixaEntrega->getCepInicial())
                    ->setParameter("%cepfinal%", $faixaEntrega->getCepFinal())
                    ->addViolation();
            }
        }
    }
    
    private function adicionaViolacaoDoCep(QueryBuilder $query, $message, $path, $cep) {
        $result = $query->getQuery()->getResult();
        if(count($result)) {
            $this->context
                ->buildViolation($message)
                ->atPath($path)
                ->setParameter("%cep%", $cep)
                ->addViolation();
        }
    }

}
