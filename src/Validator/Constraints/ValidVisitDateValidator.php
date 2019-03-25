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

        /* Not Sunday Validator */
        $weekDay = date('D', $value->getTimestamp());

        if ('Sun' == $weekDay || 'Tue' == $weekDay) {
            $this->context->buildViolation($constraint->messageSun)
                ->setParameter('{{ visitDate }}', ($weekDay == 'Sun') ? 'dimanche' : 'mardi')
                ->addViolation();
        }

        /* Not Holiday Validator */
        $visitDateTimestamp = $value->getTimestamp();
        $visitYear = date('Y', $visitDateTimestamp);

        $easterDate  = easter_date($visitYear);
        $easterDay   = date('j', $easterDate);
        $easterMonth = date('n', $easterDate);
        $easterYear   = date('Y', $easterDate);

        $holidays = array(
            // Dates fixes
            mktime(0, 0, 0, 1,  1,  $visitYear),  // 1er janvier
            mktime(0, 0, 0, 5,  1,  $visitYear),  // Fête du travail
            mktime(0, 0, 0, 5,  8,  $visitYear),  // Victoire des alliés
            mktime(0, 0, 0, 7,  14, $visitYear),  // Fête nationale
            mktime(0, 0, 0, 8,  15, $visitYear),  // Assomption
            mktime(0, 0, 0, 11, 1,  $visitYear),  // Toussaint
            mktime(0, 0, 0, 11, 11, $visitYear),  // Armistice
            mktime(0, 0, 0, 12, 25, $visitYear),  // Noel

            // Dates variables
            mktime(0, 0, 0, $easterMonth, $easterDay + 1,  $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 39, $easterYear),
            mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
        );

        sort($holidays);

        if (in_array($visitDateTimestamp, $holidays, true)) {
            $this->context->buildViolation($constraint->messageHolidays)
                ->addViolation();
        }
    }
}