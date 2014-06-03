<?php

namespace SmartInformationSystems\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SmartInformationSystemsEmailBundle:Default:index.html.twig', array('name' => $name));
    }
}
