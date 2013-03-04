<?php

namespace DjPanel\ApiBundle\Controller;

use DjPanel\MainBundle\Entity\StreamItem;
use DjPanel\MainBundle\LiquidSoap;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StationController extends ApiController
{

    public function infoAction(Request $request)
    {
        // Check API Key
        if (!$this->checkApiKey()) {
            return $this->createApiAuthenticationError();
        }

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
        // Check API Key
        if (!$this->checkApiKey()) {
            return $this->createApiAuthenticationError();
        }

        // Get now playing data from Liquidsoap
        $nowPlaying = LiquidSoap::getNowPlaying();

        return new Response(json_encode($nowPlaying));
    }

    public function shoutoutAction(Request $request)
    {
        // Check API Key
        if (!$this->checkApiKey()) {
            return $this->createApiAuthenticationError();
        }

        // Submit Shoutout
        $content = $request->get("content");
        $via = $request->get("via");
        $username = $request->get("username");

        if ($username == null || $via == null || $content == null) {
            return $this->createApiParameterError();
        }

        // Create new Shoutout
        $shoutout = new StreamItem();
        $shoutout->setType(StreamItem::TYPE_SHOUTOUT);
        $shoutout->setTime(new \DateTime());
        $shoutout->setContent($content);
        $shoutout->setVia($via);
        $shoutout->setUsername($username);

        // Persist
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($shoutout);
        $entityManager->flush();

        return new Response(json_encode(array("status" => "SUCCESS", "itemid" => $shoutout->getId())));
    }
}
