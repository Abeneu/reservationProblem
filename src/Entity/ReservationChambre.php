<?php

namespace App\Entity;

use App\Repository\ReservationChambreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationChambreRepository::class)
 */
class ReservationChambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_chambre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $labelAgeRange;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Reservation::class, inversedBy="reservationChambres" , cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Reservation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumChambre(): ?int
    {
        return $this->num_chambre;
    }

    public function setNumChambre(int $num_chambre): self
    {
        $this->num_chambre = $num_chambre;

        return $this;
    }

    public function getLabelAgeRange(): ?string
    {
        return $this->labelAgeRange;
    }

    public function setLabelAgeRange(string $labelAgeRange): self
    {
        $this->labelAgeRange = $labelAgeRange;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->Reservation;
    }

    public function setReservation(?Reservation $Reservation): self
    {
        $this->Reservation = $Reservation;

        return $this;
    }

    public function __toString()
    {
        return $this->getLabelAgeRange();
    }


}
