<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 08/03/2019
 * Time: 19:13
 */

namespace App\EventListener;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class SessionRequestListener
{
    private const LISTENED_PATHS = [
        '/billetterie/prepareOrder',
        '/billetterie/checkoutOrder',
        '/billetterie/StripePaiementSucces',
    ];

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request =$event->getRequest();

        if (!$this->support($request)) {

            return;
        }

        if (!$request->hasPreviousSession() || null == $request->getSession()->get('ticketOrder')){
            $response = new RedirectResponse('/billetterie');
            $event->setResponse($response);
        }
    }

    public function support(Request $request)
    {
        return in_array($request->getPathInfo(), self::LISTENED_PATHS);
    }
}