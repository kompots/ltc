<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:home:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function helloWorldAction(Request $request)
    {
        if ($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->indexAction($request);
        }
        return $this->render('AppBundle:home:hello-world.html.twig');
    }

}
