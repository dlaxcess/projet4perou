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
    public $message = 'The visit date can\'t be in the past';
    public $messageSun = 'Vous ne pouvez réserver de billet pour le dimanche';
    public $messageHolidays = 'Vous ne pouvez réserver de billet pour un jour férié';
}