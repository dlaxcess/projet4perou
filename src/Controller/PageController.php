<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function billetterie()
    {
        return $this->render('pages/billetterie.html.twig');
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