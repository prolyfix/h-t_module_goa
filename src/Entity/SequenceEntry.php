<?php

namespace Prolyfix\GoaBundle\Entity;

use Prolyfix\GoaBundle\Repository\SequenceEntryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Prolyfix\GoaBundle\Entity\Number;

#[ORM\Entity(repositoryClass: SequenceEntryRepository::class)]
class SequenceEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'sequenceEntries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Number $number = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $factor = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'sequenceEntries', cascade: ['persist'])]
    private ?Sequence $sequence = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?Number
    {
        return $this->number;
    }

    public function setNumber(?Number $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getFactor(): ?float
    {
        return $this->factor;
    }

    public function setFactor(?float $factor): static
    {
        $this->factor = $factor;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSequence(): ?Sequence
    {
        return $this->sequence;
    }

    public function setSequence(?Sequence $sequence): static
    {
        $this->sequence = $sequence;
        return $this;
    }

    public function getPoints(): float
    {
        return $this->getNumber()->getPoints() * $this->getFactor() * $this->getQuantity();
    }
}
