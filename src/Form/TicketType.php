<?php

namespace App\Form;

use App\Entity\Duration;
use App\Entity\Rate;
use App\Entity\Ticket;
use App\Enum\DurationsAvailable;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
            /*->add('duration', ChoiceType::class, array(
                'choices' => DurationsAvailable::getAvailableDurations()
            ))*/
            ->add('rate', EntityType::class, array(
                'class' => Rate::class,
                'choice_label' => 'name',
                'multiple' => false
            ))
            ->add('visitorName', TextType::class)
            ->add('réserver', SubmitType::class)
            /*->add('Réserver', SubmitType::class)*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
