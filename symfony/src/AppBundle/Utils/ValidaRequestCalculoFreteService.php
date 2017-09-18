<?php

namespace AppBundle\Utils;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\RecursiveValidator;

class ValidaRequestCalculoFreteService
{
    /**
     *
     * @var RecursiveValidator
     */
    private $validator;
    
    public function __construct(RecursiveValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     *
     * @param Request $request
     * @return boolean
     */
    public function valida(Request $request)
    {
        $required = ["cep", "peso"];
        foreach ($required as $r) {
            if (!$request->get($r)) {
                return true;
            }
        }
        
        $valores["cep"] = (int)$request->get('cep');
        $valores["peso"] = $request->get('peso');
        
        $constraint = new Assert\Collection(array(
            "cep" => new Assert\Required(array(
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\LessThanOrEqual(99999999),
                new Assert\Length(array(
                    'min' => 8,
                    'max' => 8,
                ))
            )),
            "peso" =>  new Assert\Required(array(
                new Assert\NotBlank(),
                new Assert\Type('numeric'),
                new Assert\GreaterThanOrEqual(0),
            )),
        ));
        
        $violationList = $this->validator->validateValue($valores, $constraint);
        
        if (0 ==! count($violationList)) {
            return true;
        }
    }
}
