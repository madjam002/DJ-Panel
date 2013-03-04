<?php

namespace DjPanel\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowController extends ApiController
{
    public function deleteAction(Request $request)
    {
        // Check API Key
        if (!$this->checkApiKey()) {
            return $this->createApiAuthenticationError();
        }

        $showId = $request->get("showId");

        // Check for blank values
        if ($showId == null) {
            return $this->createApiParameterError();
        }

        $showRepository = $this->getDoctrine()->getRepository("DjPanelShowBundle:Show");
        $show = $showRepository->find($showId);

        // Check if Show Exists
        if ($show == null) {
            return new Response(json_encode(array("status" => "DOESNT_EXIST")));
        }

        // Delete Show
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($show);
        $entityManager->flush();

        return new Response(json_encode(array("status" => "SUCCESS")));
    }
}
