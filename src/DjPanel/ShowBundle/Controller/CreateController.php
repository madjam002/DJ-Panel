<?php

namespace DjPanel\ShowBundle\Controller;

use DjPanel\ShowBundle\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateController extends Controller
{
    public function createAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        $show = new Show();

        $newShowForm = $this->createFormBuilder($show)
                ->add("name", "text")
                ->getForm();

        // Validate Form Submission
        if ($request->isMethod("POST")) {
            $newShowForm->bind($request);

            if ($newShowForm->isValid()) {
                // Add current user to the new shows presenters
                $show->addPresenter($user);

                // Generate Random Colour for the Show
                $show->generateRandomColour();

                // Persist
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($show);
                $entityManager->flush();

                // Redirect to new Show Page
                return new RedirectResponse($this->generateUrl("dj_panel_show_list"));
            }
        }

        return $this->render("DjPanelShowBundle::create.html.twig", array(
            "createForm" => $newShowForm->createView()
        ));
    }
}
