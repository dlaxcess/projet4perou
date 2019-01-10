<?php

namespace App\Form;

use App\Entity\Discounts;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('visitorFirstName', TextType::class)
            ->add('visitorName', TextType::class)
            ->add('visitorBirthDate', BirthdayType::class, array(
                'widget' => 'choice',
                'format' => 'ddMMyyyy',
                'years' => range(1920,date('Y')),
                'data' => new \DateTime('1990-01-01'),
                'placeholder' => array(
                    'day' => 'Day', 'month' => 'Month', 'year' => 'Year',
                )
            ))
            ->add('discount', EntityType::class, array(
                'class'        => Discounts::class,
                'choice_label' => function(Discounts $discounts) {
                            return $discounts->getDiscountName() . ' : ' . $discounts->getDiscountDescription();
                            },
                'multiple'     => false,
            ))
            ->add('country', CountryType::class, array(
                'placeholder' => 'Indiquez votre pays',
                'preferred_choices' => array('FR', 'GB'),
            ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
