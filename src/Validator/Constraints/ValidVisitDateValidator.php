<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 21/10/2018
 * Time: 15:36
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidVisitDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $presentDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        $presentDate->setTime(0,0);

        if ($value < $presentDate) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}