<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 11/01/19
 * Time: 15:57
 */

namespace App\Validator\Constraints;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ThousandLimitValidator extends ConstraintValidator
{
    private $ticketOrderRepository;
    private $selectedDateTicketAmount = 0;

    public function __construct(EntityManagerInterface $em)
    {
        $this->ticketOrderRepository = $em->getRepository('App:TicketOrder');
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $this->selectedDateTicketAmount += $this->context->getObject()->getTickets()->count();

        $selectedDateTicketOrderArray = $this->ticketOrderRepository->findByVisitDate($value);

        if ($selectedDateTicketOrderArray != null) {
            foreach ($selectedDateTicketOrderArray as $selectedDateTicketOrder) {
                $this->selectedDateTicketAmount += $selectedDateTicketOrder->getTickets()->count();
            }
        }

        if ($this->selectedDateTicketAmount > 1000) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ visitDate }}', date_format($value, 'd/m/Y'))
                ->addViolation();
        }
    }
}