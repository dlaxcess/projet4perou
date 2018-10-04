<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 27/09/2018
 * Time: 21:32
 */

namespace App\Services;



use App\Entity\Ticket;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;

class TicketManager
{
    private $em;
    private $formFactoryInterface;

    public function __construct(EntityManagerInterface $em, FormFactoryInterface $formFactoryInterface)
    {
        $this->em = $em;
        $this->formFactoryInterface = $formFactoryInterface;
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

    public function form()
    {
        $ticket = new Ticket();

        /*$formBuilder = $this->formFactoryInterface->createBuilder(FormType::class, $ticket);

        $formBuilder
            ->add('date', DateType::class)
            ->add('duration', TextType::class)
            ->add('booked', CheckboxType::class)
            ->add('Réserver', SubmitType::class)
        ;

        $form = $formBuilder->getForm();*/
        $form = $this->formFactoryInterface->create(TicketType::class, $ticket);

        return $form;
    }
}