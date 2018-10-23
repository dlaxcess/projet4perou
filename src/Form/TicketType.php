<?php

namespace App\Form;

use App\Entity\Duration;
use App\Entity\Rate;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate',     DateType::class)
            ->add('duration', EntityType::class, array(
                'class' => Duration::class,
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('rate', EntityType::class, array(
                'class' => Rate::class,
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('visitorBirthDate', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('visitorName', TextType::class)
            ->add('réserver', SubmitType::class)
        ;

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $ticket = $event->getData();
                $ticket->setTicketPrice(10);

                $todayDate =  new \DateTime('now', new \DateTimeZone('Europe/Paris'));

                if (null === $ticket) {
                    return;
                }

                if ($ticket->getVisitorBirthDate() > $todayDate) {
                    $ticket->setTicketPrice(20);

                    $event->getForm()->add('ticketPrice', IntegerType::class, array(
                        'required' => false,
                    ));
                }
                else {
                    /*$event->getForm()->remove('ticketPrice');*/
                    $event->getForm()->add('ticketPrice', IntegerType::class, array(
                        'required' => false,
                    ));
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
