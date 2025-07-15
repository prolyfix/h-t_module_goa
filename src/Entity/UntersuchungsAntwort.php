<?php

namespace Prolyfix\GoaBundle\Entity;

use Prolyfix\GoaBundle\Repository\UntersuchungsAntwortRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\UntersuchungsQuestion;

#[ORM\Entity(repositoryClass: UntersuchungsAntwortRepository::class)]
class UntersuchungsAntwort
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'untersuchungsAntworts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UntersuchungsQuestion $untersuchungsQuestion = null;

    #[ORM\Column(length: 255)]
    private ?string $response = null;

    /**
     * @var Collection<int, Sequence>
     */
    #[ORM\ManyToMany(targetEntity: Sequence::class)]
    private Collection $sequences;

    /**
     * @var Collection<int, Number>
     */
    #[ORM\ManyToMany(targetEntity: Number::class)]
    private Collection $numbers;

    public function __construct()
    {
        $this->sequences = new ArrayCollection();
        $this->numbers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUntersuchungsQuestion(): ?UntersuchungsQuestion
    {
        return $this->untersuchungsQuestion;
    }

    public function setUntersuchungsQuestion(?UntersuchungsQuestion $untersuchungsQuestion): static
    {
        $this->untersuchungsQuestion = $untersuchungsQuestion;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): static
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return Collection<int, Sequence>
     */
    public function getSequences(): Collection
    {
        return $this->sequences;
    }

    public function addSequence(Sequence $sequence): static
    {
        if (!$this->sequences->contains($sequence)) {
            $this->sequences->add($sequence);
        }

        return $this;
    }

    public function removeSequence(Sequence $sequence): static
    {
        $this->sequences->removeElement($sequence);

        return $this;
    }

    /**
     * @return Collection<int, Number>
     */
    public function getNumbers(): Collection
    {
        return $this->numbers;
    }

    public function addNumber(Number $number): static
    {
        if (!$this->numbers->contains($number)) {
            $this->numbers->add($number);
        }

        return $this;
    }

    public function removeNumber(Number $number): static
    {
        $this->numbers->removeElement($number);

        return $this;
    }
}
