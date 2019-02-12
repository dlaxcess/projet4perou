<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 12/02/19
 * Time: 15:57
 */

namespace App\Services;


use App\Entity\TicketOrder;

class StripeCheckout
{
    private $stripeKey;

    public function __construct(string $stripe_key)
    {
        $this->stripeKey = $stripe_key;
    }

    public function stripePay(TicketOrder $ticketOrder, string $token)
    {
        $notice = 'success';
        $message = 'Le paiement de votre commande a bien été effectué, un mail récapitulatif de de votre commande a été envoyé à l\'adresse renseignée.';
        $route = 'paymentSuccess';

        \Stripe\Stripe::setApiKey($this->stripeKey);

        try {
            \Stripe\Charge::create([
                'amount' => 100*$ticketOrder->getTotalPrice(),
                'currency' => 'eur',
                'description' => 'Paiement Stripe - Commande Billets Louvre',
                'source' => $token,
            ]);
        } catch(\Stripe\Error\Card $e) {
            $notice = 'error';
            $message = 'Une erreur est survenue pendant le paiement, veuillez renouveler l\'opération';
            $route = 'prepareOrder';
        }
        return ['notice' => $notice, 'message' => $message, 'route' => $route];
    }
}