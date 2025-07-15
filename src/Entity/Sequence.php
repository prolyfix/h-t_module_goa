<?php

namespace Prolyfix\GoaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prolyfix\GoaBundle\Repository\SequenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SequenceRepository::class)]
class Sequence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    /**
     * @var Collection<int, SequenceEntry>
     */
    #[ORM\OneToMany(targetEntity: SequenceEntry::class, mappedBy: 'sequence', cascade: ['persist'])]
    private Collection $sequenceEntries;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $defaultFactor = null;

    public function __construct()
    {
        $this->sequenceEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, SequenceEntry>
     */
    public function getSequenceEntries(): Collection
    {
        return $this->sequenceEntries;
    }

    public function addSequenceEntry(SequenceEntry $sequenceEntry): static
    {
        if (!$this->sequenceEntries->contains($sequenceEntry)) {
            $this->sequenceEntries->add($sequenceEntry);
            $sequenceEntry->setSequence($this);
        }

        return $this;
    }

    public function removeSequenceEntry(SequenceEntry $sequenceEntry): static
    {
        if ($this->sequenceEntries->removeElement($sequenceEntry)) {
            // set the owning side to null (unless already changed)
            if ($sequenceEntry->getSequence() === $this) {
                $sequenceEntry->setSequence(null);
            }
        }

        return $this;
    }

    public function getDefaultFactor(): ?string
    {
        return $this->defaultFactor;
    }

    public function setDefaultFactor(?string $defaultFactor): static
    {
        $this->defaultFactor = $defaultFactor;

        return $this;
    }

    public function setToMinFactor(): static
    {
        foreach ($this->sequenceEntries as $sequenceEntry) {
            $sequenceEntry->setFactor(1);
        }
        return $this;
    }

    public function getTotalPoints($pointValue): float
    {
        $total = 0;
        foreach ($this->sequenceEntries as $sequenceEntry) {
            if($sequenceEntry->getNumber()->getFixedPrice() !== null){
		        $total += $sequenceEntry->getNumber()->getFixedPrice() * $sequenceEntry->getQuantity() / $pointValue;
            }
            else
                $total += $sequenceEntry->getNumber()->getPoints() * $sequenceEntry->getFactor() * $sequenceEntry->getQuantity();
        }
        return $total;
    }

}
