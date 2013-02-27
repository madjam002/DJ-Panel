<?php

namespace DjPanel\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConfigurationController extends Controller
{
    public function mainAction()
    {
        return $this->render('DjPanelAdminBundle::main.html.twig');
    }
}
