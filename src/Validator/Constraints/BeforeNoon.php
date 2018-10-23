<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 21/10/2018
 * Time: 15:22
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BeforeNoon extends Constraint
{
    public $message = 'The duration "{{ duration }}" cannot be choosen after noon';
}