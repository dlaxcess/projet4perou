<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 11/01/19
 * Time: 15:57
 */

namespace App\Validator\Constraints;


use App\Repository\TicketRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ThousandLimitValidator extends ConstraintValidator
{
    private $ticketRepository;
    private $selectedDateTicketAmount = 0;

    public function __construct(TicketRepository $ticketRepo)
    {
        $this->ticketRepository = $ticketRepo;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return;
        }

        $this->selectedDateTicketAmount += $this->context->getObject()->getTickets()->count();

        $this->selectedDateTicketAmount += $this->ticketRepository->getOneDateTicketAmount($value);

        if (1000 < $this->selectedDateTicketAmount) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ visitDate }}', date_format($value, 'd/m/Y'))
                ->addViolation();
        }
    }
}