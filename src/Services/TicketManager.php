<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 27/09/2018
 * Time: 21:32
 */

namespace App\Services;



use App\Entity\Ticket;
use Doctrine\ORM\EntityManagerInterface;

class TicketManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function add()
    {
        return 'ticket added';
    }

    public function addTicket($dateTicket)
    {
        /*$ticket = new Ticket();
        $ticket
            ->setDate(new \DateTime())
            ->setDuration($dateTicket)
            ->setBooked(true)
            ;

        $em = $this->getDoctrine()->getManager();

        $em->persist($ticket);

        $em->flush();*/

        /*$repository = $this->getDoctrine()->getManager()->getRepository(Ticket::class);
        $ticket = $repository->find($dateTicket);*/

        $ticket = $this->em->getRepository(Ticket::class)->find($dateTicket);


        if (null === $ticket)
        {
            throw new NotFoundHttpException("l'annonce d'id " . $dateTicket . " n'existe pas!");
        }


        return $ticket->getDuration();
    }
}