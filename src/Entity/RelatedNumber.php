<?php

namespace Prolyfix\GoaBundle\Entity;

use Prolyfix\GoaBundle\Repository\RelatedNumberRepository;
use Doctrine\ORM\Mapping as ORM;
use Prolyfix\GoaBundle\Entity\Number;

#[ORM\Entity(repositoryClass: RelatedNumberRepository::class)]
class RelatedNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relatedNumbers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Number $startNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $relation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Number $targteNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartNumber(): ?Number
    {
        return $this->startNumber;
    }

    public function setStartNumber(?Number $startNumber): static
    {
        $this->startNumber = $startNumber;

        return $this;
    }

    public function getRelation(): ?string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

    public function getTargteNumber(): ?Number
    {
        return $this->targteNumber;
    }

    public function setTargteNumber(?Number $targteNumber): static
    {
        $this->targteNumber = $targteNumber;

        return $this;
    }
}
