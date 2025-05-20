<?php

namespace App\Entity;

use App\Repository\LibraryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LibraryRepository::class)]
class Library
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titel = null;

    #[ORM\Column]
    private ?int $isbn = null;

    #[ORM\Column(length: 255)]
    private ?string $forfattare = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(string $titel): static
    {
        $this->titel = $titel;

        return $this;
    }

    public function getIsbn(): ?int
    {
        return $this->isbn;
    }

    public function setIsbn(int $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getForfattare(): ?string
    {
        return $this->forfattare;
    }

    public function setForfattare(string $forfattare): static
    {
        $this->forfattare = $forfattare;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): static
    {
        $this->img = $img;

        return $this;
    }
}
