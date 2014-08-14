<?php

namespace Wind\Bundle\MtgparseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WindMtgparseBundle:Default:index.html.twig', array('name' => '1'));
    }
}
