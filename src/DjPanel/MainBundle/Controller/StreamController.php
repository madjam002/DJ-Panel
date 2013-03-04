<?php

namespace DjPanel\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class StreamController extends Controller
{

    public function viewAction()
    {
        $streamRepository = $this->getDoctrine()->getRepository("DjPanelMainBundle:StreamItem");

        $streamItems = $streamRepository->findAll();

        return $this->render("DjPanelMainBundle:Stream:view.html.twig", array(
            "streamItems" => $streamItems
        ));
    }

}
