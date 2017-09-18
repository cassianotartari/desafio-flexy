<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CepNoIntervalo extends Constraint
{
    public $message = 'cep_no_intervalo';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy()
    {
        return 'cep_no_intervalo';
    }
}
