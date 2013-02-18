<?php

namespace DjPanel\ShowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListController extends Controller
{
    public function listAction()
    {
        $user = $this->get("security.context")->getToken()->getUser();

        return $this->render("DjPanelShowBundle::list.html.twig", array("shows" => $user->getShows()));
    }
}
