<?php

namespace App\Form;

use App\Entity\TicketOrder;
use App\Entity\Duration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitDate',     DateType::class, array(
                'format' => 'dd-MM-yyyy',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker form-control-sm'],
                'label' => 'Date de la visite',
                'block_name' => 'visitDate',
            ))
            ->add('duration', EntityType::class, array(
                'class' => Duration::class,
                'choice_label' => 'name',
                'multiple' => false,
                'attr' => ['class' => 'form-control-sm'],
                'label' => 'Durée de la visite',
            ))
            ->add('bookingEmail', EmailType::class, array(
                'attr' => ['class' => 'form-control-sm'],
                'label' => 'Email relatif à la commande',
            ))
            ->add('tickets', CollectionType::class, array(
                'entry_type'   => TicketType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                /*'attr' => ['class' => 'form-control-sm'],*/
                /*'block_name' => 'tickets',*/
                /*'label' => false,*/
            ))
            /*->add('réserver', SubmitType::class)*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketOrder::class,
        ]);
    }
}
