<?php

namespace Prolyfix\GoaBundle\Entity;

use Prolyfix\GoaBundle\Repository\UntersuchungsCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UntersuchungsCategoryRepository::class)]
class UntersuchungsCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, UntersuchungsQuestion>
     */
    #[ORM\OneToMany(targetEntity: UntersuchungsQuestion::class, mappedBy: 'untersuchungsCategory',cascade: ['persist', 'remove'])]
    private Collection $untersuchungsQuestions;

    public function __construct()
    {
        $this->untersuchungsQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UntersuchungsQuestion>
     */
    public function getUntersuchungsQuestions(): Collection
    {
        return $this->untersuchungsQuestions;
    }

    public function addUntersuchungsQuestion(UntersuchungsQuestion $untersuchungsQuestion): static
    {
        if (!$this->untersuchungsQuestions->contains($untersuchungsQuestion)) {
            $this->untersuchungsQuestions->add($untersuchungsQuestion);
            $untersuchungsQuestion->setUntersuchungsCategory($this);
        }

        return $this;
    }

    public function removeUntersuchungsQuestion(UntersuchungsQuestion $untersuchungsQuestion): static
    {
        if ($this->untersuchungsQuestions->removeElement($untersuchungsQuestion)) {
            // set the owning side to null (unless already changed)
            if ($untersuchungsQuestion->getUntersuchungsCategory() === $this) {
                $untersuchungsQuestion->setUntersuchungsCategory(null);
            }
        }

        return $this;
    }
}
