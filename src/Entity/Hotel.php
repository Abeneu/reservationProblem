<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=AgeRange::class, mappedBy="Hotel")
     */
    private $ageRanges;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="hotel")
     */
    private $reservations;

    /**
     * @ORM\Column(type="integer")
     */
    private $paxPerChambre;

    public function __construct()
    {
        $this->ageRanges = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|AgeRange[]
     */
    public function getAgeRanges(): Collection
    {
        return $this->ageRanges;
    }

    public function addAgeRange(AgeRange $ageRange): self
    {
        if (!$this->ageRanges->contains($ageRange)) {
            $this->ageRanges[] = $ageRange;
            $ageRange->setHotel($this);
        }

        return $this;
    }

    public function removeAgeRange(AgeRange $ageRange): self
    {
        if ($this->ageRanges->removeElement($ageRange)) {
            // set the owning side to null (unless already changed)
            if ($ageRange->getHotel() === $this) {
                $ageRange->setHotel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHotel($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHotel() === $this) {
                $reservation->setHotel(null);
            }
        }

        return $this;
    }

    public function getPaxPerChambre(): ?int
    {
        return $this->paxPerChambre;
    }

    public function setPaxPerChambre(int $paxPerChambre): self
    {
        $this->paxPerChambre = $paxPerChambre;

        return $this;
    }

    public function __toString()
    {
        return $this->name ;
    }


}
