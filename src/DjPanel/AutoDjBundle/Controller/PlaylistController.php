<?php

namespace DjPanel\AutoDjBundle\Controller;

use DjPanel\MainBundle\LiquidSoap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlaylistController extends Controller
{
    public function viewAction()
    {
        return $this->render('DjPanelAutoDjBundle:Playlist:view.html.twig');
    }

    public function listAction()
    {
        $playlistRepository = $this->getDoctrine()->getRepository("DjPanelAutoDjBundle:Playlist");
        $playlists = $playlistRepository->findAll();

        return $this->render("DjPanelAutoDjBundle:Playlist:list.html.twig", array("playlists" => $playlists));
    }
}
