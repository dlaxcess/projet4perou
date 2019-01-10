<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 21/10/2018
 * Time: 15:33
 */

namespace App\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class BeforeNoonValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $datePm = new \DateTime();
        $datePm->setTime(14, 0);

        $visitDate = $this->context->getObject()->getVisitDate();


        $dateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));


        if ($datePm < $dateTime && $value->getName() == 'day' && $visitDate <= $dateTime) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ duration }}', $value->getName())
                ->addViolation();
        }

    }
}