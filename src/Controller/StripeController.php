<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 16/01/19
 * Time: 21:00
 */

namespace App\Controller;


use App\Entity\Discounts;
use App\Entity\Duration;
use App\Repository\DiscountsRepository;
use App\Repository\DurationRepository;
use App\Services\TicketOrderRefactorer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/billetterie/prepareOrder", name="prepareOrder")
     */
    public function prepareStripeOrder(SessionInterface $session)
    {
            $ticketOrder = $session->get('ticketOrder');

        return $this->render('stripe/prepareStripeOrder.html.twig', ['ticketOrder' => $ticketOrder]);
    }

    /**
     * @Route(
     *     "/billetterie/chekoutOrder",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function checkoutOrder(Request $request, SessionInterface $session)
    {
        $ticketOrder = $session->get('ticketOrder');

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $stripeKey = getenv('STRIPE_KEY');

        \Stripe\Stripe::setApiKey($stripeKey);

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $request->request->get('stripeToken');

        try {
            \Stripe\Charge::create([
                'amount' => 100*$ticketOrder->getTotalPrice(),
                'currency' => 'eur',
                'description' => 'Paiement Stripe - Commande Billets Louvre',
                'source' => $token,
            ]);
            $this->addFlash("success","Le paiement de votre commande a bien été effectué, un mail récapitulatif de de votre commande a été envoyé à l'adresse renseignée.");

            return $this->redirectToRoute("paymentSuccess");

        } catch(\Stripe\Error\Card $e) {
            $this->addFlash("error","Une erreur est survenue pendant le paiement, veuillez renouveler l'opération");

            return $this->redirectToRoute("prepareOrder");

            // The card has been declined

        }
    }

    /**
     * @Route("/billetterie/StripePaiementSucces", name="paymentSuccess")
     */
    public function paymentSuccess(SessionInterface $session, \Swift_Mailer $mailer, TicketOrderRefactorer $ticketOrderRefactorer)
    {
        $ticketOrder = $session->get('ticketOrder');

//        dd($ticketOrder);

        if ($ticketOrder) {
//            $duration = $this->getDoctrine()->getManager()->getRepository(Duration::class)->find($ticketOrder->getDuration()->getId());
//            $ticketOrder->setDuration($duration);
//
//            $ticketCollection = $ticketOrder->getTickets();
//            foreach ($ticketCollection as $ticket) {
//                $discount = $this->getDoctrine()->getManager()->getRepository(Discounts::class)->find($ticket->getDiscount()->getId());
//                $ticket->setDiscount($discount);
//            }

            $ticketOrder = $ticketOrderRefactorer->refactorTicketOrder($ticketOrder);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketOrder);
            $em->flush();

            $session->clear();

            // Envoi du mail Récap
            $message = (new \Swift_Message('Commande n°' . $ticketOrder->getBookingCode()))
                ->setFrom('contact.philippe.perou@gmail.com')
                ->setTo($ticketOrder->getBookingEmail())
                ->setBody(
                    $this->renderView(
                        'mails/validatedOrderMail.html.twig',
                        array('ticketOrder' => $ticketOrder)
                    ),
                    'text/html'
                )
            ;

            $mailer->send($message);
        }

        return $this->render('stripe/succesStripePayement.html.twig', ['ticketOrder' => $ticketOrder]);
    }
}