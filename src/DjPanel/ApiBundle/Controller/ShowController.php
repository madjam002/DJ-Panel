<?php

namespace DjPanel\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends Controller
{
    public function deleteAction(Request $request)
    {
        $user = $this->get("security.context")->getToken()->getUser();

        $showId = $request->get("showId");

        // Check for blank values
        if ($showId == null) {
            return new Response(json_encode(array("status" => "INVALID_PARAMS")));
        }

        $showRepository = $this->getDoctrine()->getRepository("DjPanelShowBundle:Show");
        $show = $showRepository->find($showId);

        // Check if Show Exists
        if ($show == null || !$show->getPresenters()->contains($user)) {
            return new Response(json_encode(array("status" => "DOESNT_EXIST")));
        }

        // Delete Show
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($show);
        $entityManager->flush();

        return new Response(json_encode(array("status" => "SUCCESS")));
    }
}
