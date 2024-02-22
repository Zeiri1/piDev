<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
<<<<<<< HEAD
    private ?string $type_transport = null;

    #[ORM\Column]
    private ?int $capacite = null;

    #[ORM\Column(length: 255)]
=======
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $capacité = null;

    #[ORM\Column(length: 255, nullable: true)]
>>>>>>> 0a63f655ee3a165408705d59504f86b58bafbf96
    private ?string $statut = null;

    public function getId(): ?int
    {
        return $this->id;
    }

<<<<<<< HEAD
    public function getTypeTransport(): ?string
    {
        return $this->type_transport;
    }

    public function setTypeTransport(string $type_transport): static
    {
        $this->type_transport = $type_transport;
=======
    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
>>>>>>> 0a63f655ee3a165408705d59504f86b58bafbf96

        return $this;
    }

<<<<<<< HEAD
    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;
=======
    public function getCapacité(): ?string
    {
        return $this->capacité;
    }

    public function setCapacité(?string $capacité): static
    {
        $this->capacité = $capacité;
>>>>>>> 0a63f655ee3a165408705d59504f86b58bafbf96

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

<<<<<<< HEAD
    public function setStatut(string $statut): static
=======
    public function setStatut(?string $statut): static
>>>>>>> 0a63f655ee3a165408705d59504f86b58bafbf96
    {
        $this->statut = $statut;

        return $this;
    }
}
