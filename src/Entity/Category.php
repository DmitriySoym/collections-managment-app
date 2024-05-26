<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\Validator\CollectionCustomAttribute;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\ManyToOne(inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\ManyToOne(inversedBy: 'categoryitems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryType $catygoryType = null;

    /**
     * @var Collection<int, CustomAttribute>
     */
    #[ORM\OneToMany(targetEntity: CustomAttribute::class, mappedBy: 'category', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[CollectionCustomAttribute()]
    private Collection $customAttributes;

    public function __construct()
    {
        $this->categoryCollections = new ArrayCollection();
        $this->customAttributes = new ArrayCollection();
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

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

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): static
    {
        $this->updated = $updated;

        return $this;
    }

    public function getCatygoryType(): ?CategoryType
    {
        return $this->catygoryType;
    }

    public function setCatygoryType(?CategoryType $catygoryType): static
    {
        $this->catygoryType = $catygoryType;

        return $this;
    }

    /**
     * @return Collection<int, CustomAttribute>
     */
    public function getCustomAttributes(): Collection
    {
        return $this->customAttributes;
    }

    public function addCustomAttribute(CustomAttribute $customAttribute): static
    {
        if (!$this->customAttributes->contains($customAttribute)) {
            $this->customAttributes->add($customAttribute);
            $customAttribute->setCategory($this);
        }

        return $this;
    }

    public function removeCustomAttribute(CustomAttribute $customAttribute): static
    {
        if ($this->customAttributes->removeElement($customAttribute)) {
            // set the owning side to null (unless already changed)
            if ($customAttribute->getCategory() === $this) {
                $customAttribute->setCategory(null);
            }
        }

        return $this;
    }
}
