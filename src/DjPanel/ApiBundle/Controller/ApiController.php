<?php

namespace DjPanel\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class ApiController extends Controller
{

    protected function isLoggedIn()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $user != null;
    }

    protected function checkApiKey()
    {
        $secret = $this->container->getParameter("api_secret");

        if ($this->getRequest()->get("api_secret") != $secret) {
            return false;
        }

        return true;
    }

    protected function createApiAuthenticationError()
    {
        return new Response(json_encode(array("status" => "API_AUTH_ERROR")));
    }

}
