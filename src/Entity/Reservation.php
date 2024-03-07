<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datereservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Offre $offre = null;

    #[ORM\Column(nullable: true)]
    #[Assert\NotBlank(message:'nombreplace required')]
    private ?int $nombreplace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatereservation(): ?\DateTimeInterface
    {
        return $this->datereservation;
    }

    public function setDatereservation(?\DateTimeInterface $datereservation): static
    {
        $this->datereservation = $datereservation;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    public function getNombreplace(): ?int
    {
        return $this->nombreplace;
    }

    public function setNombreplace(?int $nombreplace): static
    {
        $this->nombreplace = $nombreplace;

        return $this;
    }

}
