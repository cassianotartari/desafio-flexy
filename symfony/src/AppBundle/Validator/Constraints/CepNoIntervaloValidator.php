<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use AppBundle\Entity\FaixaEntrega;
use AppBundle\Repository\FaixaEntregaRepository;

class CepNoIntervaloValidator extends ConstraintValidator
{
    protected $em;
    
    /**
     *
     * @var FaixaEntregaRepository
     */
    private $repositorioFaixaEntrega;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repositorioFaixaEntrega = $this->em->getRepository('AppBundle:FaixaEntrega');
    }
    
    /**
     *
     * @param \AppBundle\Entity\FaixaEntrega $faixaEntrega
     * @param Constraint $constraint
     * @return type
     */
    public function validate($faixaEntrega, Constraint $constraint)
    {
        $faixaEntregaAntesSubmitEdit = $this->em
            ->getUnitOfWork()
            ->getOriginalEntityData($faixaEntrega);
        
        //se não tem faixa entrega antiga então estamos no create de uma faixa de entrega
        if (empty($faixaEntregaAntesSubmitEdit)) {
            $this->validadeOnCreate($faixaEntrega, $constraint);
            return;
        }
        
        //daqui pra baixo é pro update
        
        //se cep inicial e cep final novo e antigo forem iguais não precisa validar
        if ($faixaEntrega->getCepInicial() == $faixaEntregaAntesSubmitEdit['cepInicial'] && $faixaEntrega->getCepFinal() == $faixaEntregaAntesSubmitEdit['cepFinal']) {
            return;
        }

        //verifica somente o cep inicial para adicionar mensagem personalizada pro campo dele
        $cep = $faixaEntrega->getCepInicial();
        if ($cep != $faixaEntregaAntesSubmitEdit['cepInicial']) {
            $this->validaCepOnUpdate($cep, $faixaEntrega, 'cepInicial', $constraint);
        }
        
        //verifica somente o cep final para adicionar mensagem personalizada pro campo dele
        $cep = $faixaEntrega->getCepFinal();
        if ($cep != $faixaEntregaAntesSubmitEdit['cepFinal']) {
            $this->validaCepOnUpdate($cep, $faixaEntrega, 'cepFinal', $constraint);
        }
        
        //verifica cep inicial e cep final juntos para adicionar mensagem no formulário inteiro
        if ($cep != $faixaEntregaAntesSubmitEdit['cepFinal'] && $cep != $faixaEntregaAntesSubmitEdit['cepInicial']) {
            /* @var $query \Doctrine\ORM\QueryBuilder */
            $query = $this->repositorioFaixaEntrega->verificaFaixasConflitantesPorCepsExcluindoASi(
                $faixaEntrega->getCepInicial(),
                $faixaEntrega->getCepFinal(),
                $faixaEntrega
            );
            
            $result = $query->getQuery()->getResult();
            if (count($result)) {
                //adiciona erro na classe
                $this->context
                    ->buildViolation('cepinicial_cepfinal_no_intervalo')
                    ->setParameter("%cepinicial%", $faixaEntrega->getCepInicial())
                    ->setParameter("%cepfinal%", $faixaEntrega->getCepFinal())
                    ->addViolation();
            }
        }
    }
    
    private function validadeOnCreate(FaixaEntrega $faixaEntrega, Constraint $constraint)
    {
       
        //cep inicial está no intervalo?
        $this->validaCepOnCreate($faixaEntrega->getCepInicial(), $faixaEntrega, 'cepInicial', $constraint);

        //cep final está no intervalo?
        $this->validaCepOnCreate($faixaEntrega->getCepFinal(), $faixaEntrega, 'cepFinal', $constraint);

        //Verifica se o cep inicial ou cep final fornecidos já estão presentes em algum intervalo já cadastradao para uma mesma transportadora
        /* @var $query \Doctrine\ORM\QueryBuilder */
        $query = $this->repositorioFaixaEntrega->verificaFaixasConflitantesPorCeps(
            $faixaEntrega->getCepInicial(),
            $faixaEntrega->getCepFinal(),
            $faixaEntrega->getTransportadora()
        );

        $result = $query->getQuery()->getResult();
        if (count($result)) {
            //adiciona erro na classe
            $this->context
                ->buildViolation('cepinicial_cepfinal_no_intervalo')
                ->setParameter("%cepinicial%", $faixaEntrega->getCepInicial())
                ->setParameter("%cepfinal%", $faixaEntrega->getCepFinal())
                ->addViolation();
        }
    }

    private function validaCepOnUpdate($cep, FaixaEntrega $faixaEntrega, $path, Constraint $constraint)
    {
        $query = $this->repositorioFaixaEntrega->verificaFaixasConflitantesPorCepUnicoExcluindoASi($cep, $faixaEntrega);
        $this->adicionaViolacaoDoCep(
            $query,
            $constraint->message,
            $path,
            $cep
        );
    }
    
    private function validaCepOnCreate($cep, FaixaEntrega $faixaEntrega, $path, Constraint $constraint)
    {
        $query = $this->repositorioFaixaEntrega->verificaFaixasConflitantesPorCepUnico($cep, $faixaEntrega->getTransportadora());
        $this->adicionaViolacaoDoCep(
            $query,
            $constraint->message,
            $path,
            $cep
        );
    }
    
    private function adicionaViolacaoDoCep(QueryBuilder $query, $message, $path, $cep)
    {
        $result = $query->getQuery()->getResult();
        if (count($result)) {
            $this->context
                ->buildViolation($message)
                ->atPath($path)
                ->setParameter("%cep%", $cep)
                ->addViolation();
        }
    }
}
