<?php

namespace DjPanel\ShowBundle\Controller;

use DateTime;
use DjPanel\ShowBundle\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TimetableController extends Controller
{
    public function showAction()
    {
        $user = $this->get("security.context")->getToken()->getUser();

        return $this->render("DjPanelShowBundle::timetable.html.twig", array(
            "shows" => $user->getShows()
        ));
    }

    public function bookAction(Request $request)
    {
        $user = $this->get("security.context")->getToken()->getUser();

        $showId = $request->get("show");
        $startDate = $request->get("startDate");
        $endDate = $request->get("endDate");

        // Check for blank values
        if ($showId == null || $startDate == null || $endDate == null) {
            return new Response(json_encode(array("status" => "INVALID_PARAMS")));
        }

        $showRepository = $this->getDoctrine()->getRepository("DjPanelShowBundle:Show");
        $show = $showRepository->find($showId);

        // Check that the show exists and the logged in user is a presenter
        if ($show == null || !$show->getPresenters()->contains($user)) {
            return new Response(json_encode(array("status" => "ERROR")));
        }

        // Check that there are no other bookings in this time range
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        $query = $this
            ->getDoctrine()
            ->getEntityManager()
            ->createQuery("SELECT b FROM DjPanelShowBundle:Booking b WHERE (b.bookingStart > :start AND b.bookingStart < :end)
                OR (b.bookingEnd > :start AND b.bookingEnd < :end)");
        $query->setParameters(array(
            "start" => $startDate,
            "end" => $endDate
        ));

        if (count($query->getArrayResult()) > 0) {
            return new Response(json_encode(array("status" => "BOOKING_OVERLAP")));
        }

        // Create new Booking
        $booking = new Booking();
        $booking->setShow($show);
        $booking->setBookedBy($user);
        $booking->setBookingStart($startDate);
        $booking->setBookingEnd($endDate);

        // Persist Booking
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        return new Response(json_encode(array("status" => "SUCCESS")));
    }

    public function unbookAction(Request $request)
    {
        $user = $this->get("security.context")->getToken()->getUser();

        $bookingId = $request->get("booking");

        // Check for blank values
        if ($bookingId == null) {
            return new Response(json_encode(array("status" => "INVALID_PARAMS")));
        }

        $bookingRepository = $this->getDoctrine()->getRepository("DjPanelShowBundle:Booking");
        $booking = $bookingRepository->find($bookingId);

        // Check if Booking Exists
        if ($booking == null || !$booking->getShow()->getPresenters()->contains($user)) {
            return new Response(json_encode(array("status" => "BOOKING_NONEXISTANT")));
        }

        // Delete Booking
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($booking);
        $entityManager->flush();

        return new Response(json_encode(array("status" => "SUCCESS")));
    }

    public function getJsonAction(Request $request)
    {
        $startDate = $request->get("start");
        $endDate = $request->get("end");

        $query = $this
            ->getDoctrine()
            ->getEntityManager()
            ->createQuery("SELECT b FROM DjPanelShowBundle:Booking b WHERE b.bookingStart > :start AND b.bookingStart < :end");
        $query->setParameters(array(
            "start" => DateTime::createFromFormat('U', $startDate),
            "end" => DateTime::createFromFormat('U', $endDate)
        ));
        $results = $query->getResult();

        $output = array();

        // Loop through each booking and output as json
        foreach ($results as $booking) {
            $output[] = array(
               "id" => $booking->getId(),
               "title" => $booking->getShow()->getName(),
               "start" => $booking->getBookingStart()->format("Y-m-d H:i:s"),
               "end" => $booking->getBookingEnd()->format("Y-m-d H:i:s"),
               "color" => $booking->getShow()->getColour(),
               "allDay" => false
            );
        }

        return new Response(json_encode($output));
    }
}
