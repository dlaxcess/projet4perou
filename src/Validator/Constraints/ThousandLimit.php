<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 11/01/19
 * Time: 15:56
 */

namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ThousandLimit extends Constraint
{
    public $message = 'La totalité des billets disponibles pour le {{ visitDate }} ont déjà été réservés';
}