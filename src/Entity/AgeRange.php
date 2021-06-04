<?php

namespace App\Entity;

use App\Repository\AgeRangeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AgeRangeRepository::class)
 */
class AgeRange
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("age:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("age:read")
     */
    private $label;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $min;

    /**
     * @ORM\Column(type="integer")
     *
     */
    private $max;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("age:read")
     */
    private $isNotLonely;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="ageRanges")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $Hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getMin(): ?int
    {
        return $this->min;
    }

    public function setMin(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getIsNotLonely(): ?bool
    {
        return $this->isNotLonely;
    }

    public function setIsNotLonely(bool $isNotLonely): self
    {
        $this->isNotLonely = $isNotLonely;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->Hotel;
    }

    public function setHotel(?Hotel $Hotel): self
    {
        $this->Hotel = $Hotel;

        return $this;
    }

    public function __toString()
    {
        return $this->label;
    }


}
