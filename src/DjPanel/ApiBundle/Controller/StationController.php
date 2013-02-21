<?php

namespace DjPanel\ApiBundle\Controller;

use DjPanel\MainBundle\LiquidSoap;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StationController extends Controller
{

    public function infoAction(Request $request)
    {
        // Is online/on air?
        $onAir = LiquidSoap::isOnline();
        $nowPlaying = null;

        if ($onAir) {
            // Now playing
            $nowPlaying = LiquidSoap::getNowPlaying();
        }

        return new Response(json_encode(array(
            "onAir" => $onAir,
            "nowPlaying" => $nowPlaying
        )));
    }

    public function nowPlayingAction(Request $request)
    {
        // Get now playing data from Liquidsoap
        $nowPlaying = LiquidSoap::getNowPlaying();

        return new Response(json_encode($nowPlaying));
    }
}
