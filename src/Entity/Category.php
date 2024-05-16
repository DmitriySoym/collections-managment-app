<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, CategoryCollection>
     */
    #[ORM\OneToMany(targetEntity: CategoryCollection::class, mappedBy: 'categotyId', orphanRemoval: true)]
    private Collection $categoryCollections;

    public function __construct()
    {
        $this->categoryCollections = new ArrayCollection();
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
     * @return Collection<int, CategoryCollection>
     */
    public function getCategoryCollections(): Collection
    {
        return $this->categoryCollections;
    }

    public function addCategoryCollection(CategoryCollection $categoryCollection): static
    {
        if (!$this->categoryCollections->contains($categoryCollection)) {
            $this->categoryCollections->add($categoryCollection);
            $categoryCollection->setCategotyId($this);
        }

        return $this;
    }

    public function removeCategoryCollection(CategoryCollection $categoryCollection): static
    {
        if ($this->categoryCollections->removeElement($categoryCollection)) {
            // set the owning side to null (unless already changed)
            if ($categoryCollection->getCategotyId() === $this) {
                $categoryCollection->setCategotyId(null);
            }
        }

        return $this;
    }
}
