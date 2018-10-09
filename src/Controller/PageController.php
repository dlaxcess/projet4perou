<?php

namespace App\Controller;



use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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
    public function billetterie(Request $request)
    {
        $ticket = new Ticket();

        /*$form = $this->get('form.factory')->create(TicketType::class, $ticket);*/
        $form = $this->createForm(TicketType::class, $ticket);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Ticket bien enregistré');

            return $this->redirectToRoute('billetterie');
        }

        return $this->render('pages/billetterie.html.twig', ['form' => $form->createView()]);
    }

    ///**
     //* @Route("/billetterie/{dateTicket}", name="billetterie2")
     //*/
    /*public function billetterie2($dateTicket, TicketManager $ticketManager)
    {
        $ticketDuration = $ticketManager->addTicket($dateTicket);

        return $this->render('pages/billetterie.html.twig', ['dateTicket' => $ticketDuration]);
    }*/

    /**
     * @Route("/infos-pratiques", name="infos_pratiques")
     */
    public function infos_pratiques()
    {
        return $this->render('pages/infos.html.twig');
    }

    public function menu(Request $request)
    {

        /*$router = $this->get('router');
        $routes = $router->getRouteCollection()->all();
        $paths = [];

        foreach ($routes as $route) {
            $paths[] = $route->getDefaults();
        }
        var_dump($paths);die;*/

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