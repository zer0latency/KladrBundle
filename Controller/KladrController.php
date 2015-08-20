<?php

namespace zer0latency\KladrBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class KladrController extends Controller
{
    /**
     * @Route("/region")
     * @Template()
     */
    public function regionAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/street")
     * @Template()
     */
    public function streetAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/doma")
     * @Template()
     */
    public function domaAction()
    {
        return array(
                // ...
            );    }

}
