<?php

namespace DjPanel\ShowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Booking
 *
 * @ORM\Table(name="bookings")
 * @ORM\Entity
 */
class Booking
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Show
     *
     * @ORM\ManyToOne(targetEntity="Show", inversedBy="bookings")
     */
    private $show;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="DjPanel\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="bookedby_id")
     */
    private $bookedBy;

    /**
     * @var datetime
     *
     * @ORM\Column(name="booking_start", type="datetime")
     */
    private $bookingStart;

    /**
     * @var datetime
     *
     * @ORM\Column(name="booking_end", type="datetime")
     */
    private $bookingEnd;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set bookingStart
     *
     * @param \DateTime $bookingStart
     * @return Booking
     */
    public function setBookingStart($bookingStart)
    {
        $this->bookingStart = $bookingStart;

        return $this;
    }

    /**
     * Get bookingStart
     *
     * @return \DateTime
     */
    public function getBookingStart()
    {
        return $this->bookingStart;
    }

    /**
     * Set bookingEnd
     *
     * @param \DateTime $bookingEnd
     * @return Booking
     */
    public function setBookingEnd($bookingEnd)
    {
        $this->bookingEnd = $bookingEnd;

        return $this;
    }

    /**
     * Get bookingEnd
     *
     * @return \DateTime
     */
    public function getBookingEnd()
    {
        return $this->bookingEnd;
    }

    /**
     * Set show
     *
     * @param \DjPanel\ShowBundle\Entity\Show $show
     * @return Booking
     */
    public function setShow(\DjPanel\ShowBundle\Entity\Show $show = null)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Get show
     *
     * @return \DjPanel\ShowBundle\Entity\Show
     */
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Set bookedBy
     *
     * @param \DjPanel\UserBundle\Entity\User $bookedBy
     * @return Booking
     */
    public function setBookedBy(\DjPanel\UserBundle\Entity\User $bookedBy = null)
    {
        $this->bookedBy = $bookedBy;

        return $this;
    }

    /**
     * Get bookedBy
     *
     * @return \DjPanel\UserBundle\Entity\User
     */
    public function getBookedBy()
    {
        return $this->bookedBy;
    }
}