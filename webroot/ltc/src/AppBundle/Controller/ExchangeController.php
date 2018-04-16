<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ExchangeRate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ExchangeController extends Controller
{
    private $em;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchDataAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $this->em = $this->getDoctrine()->getManager();
            $from = $request->get('start');
            $length = $request->get('length');
            $exchanges = $this->em->getRepository(ExchangeRate::class)->getExchangeData($from, $length);
            return new JsonResponse($exchanges);
        }
        die('I could insert die(json) here but I would rather not!');
    }


}
