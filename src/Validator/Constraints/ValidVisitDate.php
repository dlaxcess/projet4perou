<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 21/10/2018
 * Time: 15:33
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ValidVisitDate extends Constraint
{
    public $messageSun = 'Vous ne pouvez réserver de billet pour le {{ visitDate }}';
    public $messageHolidays = 'Vous ne pouvez réserver de billet pour un jour férié';
}