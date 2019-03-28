<?php
/**
 * Created by PhpStorm.
 * User: dlaxcess
 * Date: 16/01/19
 * Time: 21:00
 */

namespace App\Controller;


use App\Services\StripeCheckout;
use App\Services\TicketOrderRefactorer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     *     "/billetterie/checkoutOrder",
     *     name="order_checkout",
     *     methods="POST"
     * )
     */
    public function checkoutOrder(Request $request, SessionInterface $session, StripeCheckout $stripeCheckout)
    {
        $ticketOrder = $session->get('ticketOrder');

        // Stripe Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $request->request->get('stripeToken');

        $paiementResult = $stripeCheckout->stripePay($ticketOrder, $token);

        $this->addFlash($paiementResult['notice'], $paiementResult['message']);

        return $this->redirectToRoute($paiementResult['route']);
    }

    /**
     * @Route("/billetterie/StripePaiementSucces", name="paymentSuccess")
     */
    public function paymentSuccess(SessionInterface $session, \Swift_Mailer $mailer, TicketOrderRefactorer $ticketOrderRefactorer)
    {
        $ticketOrder = $session->get('ticketOrder');

        if ($ticketOrder) {

            $ticketOrder = $ticketOrderRefactorer->refactorTicketOrder($ticketOrder);

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketOrder);
            $em->flush();

            $session->clear();

            // Envoi du mail Récap
            $message = (new \Swift_Message('Musée du Louvre Commande n°' . $ticketOrder->getBookingCode()))
                ->setFrom('contact.philippe.perou@gmail.com')
                ->setTo($ticketOrder->getBookingEmail());

            $logoLouvre = $message->embed(\Swift_Image::fromPath('images/logo_louvre.jpg'));

            $message->setBody(
                    $this->renderView(
                        'mails/validatedOrderMail.html.twig', [
                            'ticketOrder' => $ticketOrder,
                            'logoLouvre' => $logoLouvre,
                        ]
                    ),
                    'text/html'
                );

            $mailer->send($message);
        }

        return $this->render('stripe/succesStripePayement.html.twig', ['ticketOrder' => $ticketOrder]);
    }
}