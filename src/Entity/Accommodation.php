<?php

namespace App\Entity;

use App\Repository\AccommodationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccommodationRepository::class)]
class Accommodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Adress = null;

    #[ORM\Column]
    private ?float $Price = null;

    #[ORM\Column]
    private ?int $OwnerId = null;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    #[ORM\ManyToOne]
    private ?Category $CategoryName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): static
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->OwnerId;
    }

    public function setOwnerId(int $OwnerId): static
    {
        $this->OwnerId = $OwnerId;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getCategoryName(): ?Category
    {
        return $this->CategoryName;
    }

    public function setCategoryName(?Category $CategoryName): static
    {
        $this->CategoryName = $CategoryName;

        return $this;
    }
}
