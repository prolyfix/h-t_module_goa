<?php

namespace Prolyfix\GoaBundle\Entity;

use Prolyfix\GoaBundle\Entity\RelatedNumber;
use Prolyfix\GoaBundle\Entity\SequenceEntry;
use App\Entity\TimeData;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prolyfix\GoaBundle\Repository\NumberRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumberRepository::class)]
class Number extends TimeData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $number = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $points = null;

    #[ORM\Column(nullable: true)]
    private ?float $factorAverage = null;

    #[ORM\Column(nullable: true)]
    private ?float $factorMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $myDescription = null;

    /**
     * @var Collection<int, RelatedNumber>
     */
    #[ORM\OneToMany(targetEntity: RelatedNumber::class, mappedBy: 'startNumber',cascade: ['persist', 'remove'])]
    private Collection $relatedNumbers;

    /**
     * @var Collection<int, SequenceEntry>
     */
    #[ORM\OneToMany(targetEntity: SequenceEntry::class, mappedBy: 'number')]
    private Collection $sequenceEntries;

    #[ORM\Column(nullable: true)]
    private ?float $fixedPrice = null;

    public function __construct()
    {
        parent::__construct();
        $this->relatedNumbers = new ArrayCollection();
        $this->sequenceEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getFactorAverage(): ?float
    {
        return $this->factorAverage;
    }

    public function setFactorAverage(?float $factorAverage): static
    {
        $this->factorAverage = $factorAverage;

        return $this;
    }

    public function getFactorMax(): ?float
    {
        return $this->factorMax;
    }

    public function setFactorMax(?float $factorMax): static
    {
        $this->factorMax = $factorMax;

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

    public function getMyDescription(): ?string
    {
        return $this->myDescription;
    }

    public function setMyDescription(?string $myDescription): static
    {
        $this->myDescription = $myDescription;

        return $this;
    }

    /**
     * @return Collection<int, RelatedNumber>
     */
    public function getRelatedNumbers(): Collection
    {
        return $this->relatedNumbers;
    }

    public function addRelatedNumber(RelatedNumber $relatedNumber): static
    {
        if (!$this->relatedNumbers->contains($relatedNumber)) {
            $this->relatedNumbers->add($relatedNumber);
            $relatedNumber->setStartNumber($this);
        }

        return $this;
    }

    public function removeRelatedNumber(RelatedNumber $relatedNumber): static
    {
        if ($this->relatedNumbers->removeElement($relatedNumber)) {
            // set the owning side to null (unless already changed)
            if ($relatedNumber->getStartNumber() === $this) {
                $relatedNumber->setStartNumber(null);
            }
        }

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
            $sequenceEntry->setNumber($this);
        }

        return $this;
    }

    public function removeSequenceEntry(SequenceEntry $sequenceEntry): static
    {
        if ($this->sequenceEntries->removeElement($sequenceEntry)) {
            // set the owning side to null (unless already changed)
            if ($sequenceEntry->getNumber() === $this) {
                $sequenceEntry->setNumber(null);
            }
        }

        return $this;
    }

    public function getFixedPrice(): ?float
    {
        return $this->fixedPrice;
    }

    public function setFixedPrice(?float $fixedPrice): static
    {
        $this->fixedPrice = $fixedPrice;

        return $this;
    }
}
