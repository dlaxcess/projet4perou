<?php

namespace App\Controller;



use App\Entity\TicketOrder;
use App\Form\TicketOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\TicketPriceGenerator;


class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        return $this->render('pages/homepage.html.twig');
    }

    /**
     * @Route("/billetterie", name="billetterie")
     */
    public function billetterie(Request $request, TicketPriceGenerator $ticketPriceGenerator, SessionInterface $session)
    {
        $ticketOrder = new TicketOrder();

        $form = $this->createForm(TicketOrderType::class, $ticketOrder);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            /*dd($ticketOrder);*/
            $ticketPriceGenerator->setTicketCollectionPrices($ticketOrder);

            $ticketOrder->setTotalPrice($ticketPriceGenerator->getTotalOrderPrice());

            $session->set('ticketOrder', $ticketOrder);

            return $this->redirectToRoute('prepareOrder');

        }

        return $this->render('pages/billetterie.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/infos-pratiques", name="infos_pratiques")
     */
    public function infos_pratiques()
    {
        return $this->render('pages/infos.html.twig');
    }

}