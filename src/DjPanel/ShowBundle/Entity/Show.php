<?php

namespace DjPanel\ShowBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Show
 *
 * @ORM\Table(name="shows")
 * @ORM\Entity
 */
class Show
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
     * @var string
     *
     * @Assert\NotBlank(message="Please enter a name")
     * @Assert\MinLength(limit="2", message="Please enter a name")
     * @Assert\MaxLength(limit="255", message="The show name you entered is too long")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="colour", type="string", length=32)
     */
    private $colour;

    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="DjPanel\UserBundle\Entity\User", mappedBy="shows")
     */
    private $presenters;

    /**
     * @var array
     *
     * @ORM\OneToMany(targetEntity="Booking", mappedBy="show")
     */
    private $bookings;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->presenters = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set Name
     *
     * @param string $name
     * @return Shows
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add presenters
     *
     * @param \DjPanel\UserBundle\Entity\User $presenters
     * @return Show
     */
    public function addPresenter(\DjPanel\UserBundle\Entity\User $presenters)
    {
        $presenters->addShow($this);
        $this->presenters[] = $presenters;

        return $this;
    }

    /**
     * Remove presenters
     *
     * @param \DjPanel\UserBundle\Entity\User $presenters
     */
    public function removePresenter(\DjPanel\UserBundle\Entity\User $presenters)
    {
        $presenters->removeShow($this);
        $this->presenters->removeElement($presenters);
    }

    /**
     * Get presenters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPresenters()
    {
        return $this->presenters;
    }

    /**
     * Set colour
     *
     * @param string $colour
     * @return Show
     */
    public function setColour($colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get colour
     *
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Generates a Random Show Colour
     * @return \DjPanel\ShowBundle\Entity\Show
     */
    public function generateRandomColour()
    {
        $colours = array("Crimson", "Gold", "DodgerBlue", "LimeGreen", "Maroon", "Orange", "Orchid", "YellowGreen");

        $this->colour = $colours[rand(0, count($colours) - 1)];

        return $this;
    }

    /**
     * Add bookings
     *
     * @param \DjPanel\ShowBundle\Entity\Booking $bookings
     * @return Booking
     */
    public function addBooking(\DjPanel\ShowBundle\Entity\Booking $bookings)
    {
        $this->bookings[] = $bookings;

        return $this;
    }

    /**
     * Remove bookings
     *
     * @param \DjPanel\ShowBundle\Entity\Booking $bookings
     */
    public function removeBooking(\DjPanel\ShowBundle\Entity\Booking $bookings)
    {
        $this->bookings->removeElement($bookings);
    }

    /**
     * Get bookings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBookings()
    {
        return $this->bookings;
    }
}