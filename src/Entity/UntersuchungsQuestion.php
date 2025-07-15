<?php

namespace Prolyfix\GoaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Prolyfix\GoaBundle\Repository\UntersuchungsQuestionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UntersuchungsQuestionRepository::class)]
class UntersuchungsQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'untersuchungsQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UntersuchungsCategory $untersuchungsCategory = null;

    #[ORM\Column(length: 511)]
    private ?string $question = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $possibleResponse = [];

    #[ORM\Column]
    private array $actions = [];

    /**
     * @var Collection<int, UntersuchungsAntwort>
     */
    #[ORM\OneToMany(targetEntity: UntersuchungsAntwort::class, mappedBy: 'untersuchungsQuestion',cascade: ['persist', 'remove'])]
    private Collection $untersuchungsAntworts;

    public function __construct()
    {
        $this->untersuchungsAntworts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUntersuchungsCategory(): ?UntersuchungsCategory
    {
        return $this->untersuchungsCategory;
    }

    public function setUntersuchungsCategory(?UntersuchungsCategory $untersuchungsCategory): static
    {
        $this->untersuchungsCategory = $untersuchungsCategory;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getPossibleResponse(): array
    {
        return $this->possibleResponse;
    }

    public function setPossibleResponse(array $possibleResponse): static
    {
        $this->possibleResponse = $possibleResponse;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function setActions(array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    public function __toString()
    {
        return $this->question??'';	
    }

    /**
     * @return Collection<int, UntersuchungsAntwort>
     */
    public function getUntersuchungsAntworts(): Collection
    {
        return $this->untersuchungsAntworts;
    }

    public function addUntersuchungsAntwort(UntersuchungsAntwort $untersuchungsAntwort): static
    {
        if (!$this->untersuchungsAntworts->contains($untersuchungsAntwort)) {
            $this->untersuchungsAntworts->add($untersuchungsAntwort);
            $untersuchungsAntwort->setUntersuchungsQuestion($this);
        }

        return $this;
    }

    public function removeUntersuchungsAntwort(UntersuchungsAntwort $untersuchungsAntwort): static
    {
        if ($this->untersuchungsAntworts->removeElement($untersuchungsAntwort)) {
            // set the owning side to null (unless already changed)
            if ($untersuchungsAntwort->getUntersuchungsQuestion() === $this) {
                $untersuchungsAntwort->setUntersuchungsQuestion(null);
            }
        }

        return $this;
    }
}
