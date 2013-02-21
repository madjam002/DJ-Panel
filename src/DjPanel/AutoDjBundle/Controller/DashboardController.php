<?php

namespace DjPanel\AutoDjBundle\Controller;

use DjPanel\MainBundle\LiquidSoap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function viewAction()
    {
        return $this->render('DjPanelAutoDjBundle::dashboard.html.twig',
            array(
                "autoDjName" => $this->container->getParameter("auto_dj.name")
            )
        );
    }
}
