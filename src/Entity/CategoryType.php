<?php

namespace App\Entity;

use App\Repository\CategoryTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryTypeRepository::class)]
class CategoryType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'catygoryType', orphanRemoval: true)]
    private Collection $categoryitems;

    public function __construct()
    {
        $this->categoryitems = new ArrayCollection();
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
     * @return Collection<int, Category>
     */
    public function getCategoryitems(): Collection
    {
        return $this->categoryitems;
    }

    public function addCategoryitem(Category $categoryitem): static
    {
        if (!$this->categoryitems->contains($categoryitem)) {
            $this->categoryitems->add($categoryitem);
            $categoryitem->setCatygoryType($this);
        }

        return $this;
    }

    public function removeCategoryitem(Category $categoryitem): static
    {
        if ($this->categoryitems->removeElement($categoryitem)) {
            // set the owning side to null (unless already changed)
            if ($categoryitem->getCatygoryType() === $this) {
                $categoryitem->setCatygoryType(null);
            }
        }

        return $this;
    }
}
