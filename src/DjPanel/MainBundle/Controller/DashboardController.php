<?php

namespace DjPanel\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function dashboardAction()
    {
        return $this->render("DjPanelMainBundle::dashboard.html.twig");
    }
}
