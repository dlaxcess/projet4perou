<?php

namespace App\Controller;



use App\Entity\Ticket;
use App\Entity\TicketOrder;
use App\Form\TicketOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\TicketPriceGenerator;
use App\Services\AutoOrderValGenerator;


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
    public function billetterie(Request $request, TicketPriceGenerator $ticketPriceGenerator, AutoOrderValGenerator $autoOrderValGenerator)
    {
        $ticketOrder = new TicketOrder();

        $form = $this->createForm(TicketOrderType::class, $ticketOrder);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $ticketPriceGenerator->setTicketCollectionPrices($ticketOrder);

            $ticketOrder->setTotalPrice($ticketPriceGenerator->getTotalOrderPrice());

//            $ticketOrder->setBookingCode($autoOrderValGenerator->generateBookingCode($ticketOrder));

            $em = $this->getDoctrine()->getManager();
            $em->persist($ticketOrder);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Commande bien enregistrée');

            return $this->redirectToRoute('billetterie');
        }

        $dateJourModif = new \DateTime();
        $dateJourModif->setTime(14, 0);
        $dateJour = new \DateTime('now', new \DateTimeZone('America/Argentina/Ushuaia'));

        return $this->render('pages/billetterie.html.twig', ['form' => $form->createView(), 'dateJour' => $dateJour, 'dateJourModif' => $dateJourModif]);
    }

    /**
     * @Route("/infos-pratiques", name="infos_pratiques")
     */
    public function infos_pratiques()
    {
        return $this->render('pages/infos.html.twig');
    }

    public function menu(Request $request)
    {

        $pageControllerMethods = get_class_methods($this);
        $menuItems = array();

        foreach ($pageControllerMethods as $menuItem) {
            if ($menuItem == 'menu') {
                break;
            } else {
                $menuItems[ucfirst(str_replace('_', ' ', $menuItem))] = 'app_page_' . $menuItem;
            }
        }

        return $this->render('menu/menu.html.twig', ['menuItems' => $menuItems]);
    }
}