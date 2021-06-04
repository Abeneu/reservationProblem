<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hotel;

    /**
     * @var DateTime
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=ReservationChambre::class, mappedBy="Reservation")
     */
    private $reservationChambres;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isApproved;

    public function __construct()
    {
        $this->reservationChambres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|ReservationChambre[]
     */
    public function getReservationChambres(): Collection
    {
        return $this->reservationChambres;
    }

    public function addReservationChambre(ReservationChambre $reservationChambre): self
    {
        if (!$this->reservationChambres->contains($reservationChambre)) {
            $this->reservationChambres[] = $reservationChambre;
            $reservationChambre->setReservation($this);
        }

        return $this;
    }

    public function removeReservationChambre(ReservationChambre $reservationChambre): self
    {
        if ($this->reservationChambres->removeElement($reservationChambre)) {
            // set the owning side to null (unless already changed)
            if ($reservationChambre->getReservation() === $this) {
                $reservationChambre->setReservation(null);
            }
        }

        return $this;
    }

    public function getIsApproved(): ?bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): self
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }




}
