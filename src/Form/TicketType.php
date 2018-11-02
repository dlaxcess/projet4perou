<?php

namespace App\Form;

use App\Entity\Discounts;
use App\Entity\Duration;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
            ->add('discount', EntityType::class, array(
                'class'        => Discounts::class,
                'choice_label' => function(Discounts $discounts) {
                            return $discounts->getDiscountName() . ' : ' . $discounts->getDiscountDescription();
                            },
                'multiple'     => false
            ))
            ->add('visitorBirthDate', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('visitorFirstName', TextType::class)
            ->add('visitorName', TextType::class)
            ->add('réserver', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
