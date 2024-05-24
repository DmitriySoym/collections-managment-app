<?php

namespace App\Entity;

use App\Repository\CategoryCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryCollectionRepository::class)]
class CategoryCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'categoryCollections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $categotyId = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    /**
     * @var Collection<int, CustomItemAttribute>
     */
    #[ORM\OneToMany(targetEntity: CustomItemAttribute::class, mappedBy: 'categoryCollection', orphanRemoval: true, cascade: ['persist'])]
    private Collection $customItemAttributes;

    public function __construct()
    {
        $this->customItemAttributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategotyId(): ?Category
    {
        return $this->categotyId;
    }

    public function setCategotyId(?Category $categotyId): static
    {
        $this->categotyId = $categotyId;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): static
    {
        $this->created = $created;

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

    /**
     * @return Collection<int, CustomItemAttribute>
     */
    public function getCustomItemAttributes(): Collection
    {
        return $this->customItemAttributes;
    }

    public function addCustomItemAttribute(CustomItemAttribute $customItemAttribute): static
    {
        if (!$this->customItemAttributes->contains($customItemAttribute)) {
            $this->customItemAttributes->add($customItemAttribute);
            $customItemAttribute->setCategoryCollection($this);
        }

        return $this;
    }

    public function removeCustomItemAttribute(CustomItemAttribute $customItemAttribute): static
    {
        if ($this->customItemAttributes->removeElement($customItemAttribute)) {
            // set the owning side to null (unless already changed)
            if ($customItemAttribute->getCategoryCollection() === $this) {
                $customItemAttribute->setCategoryCollection(null);
            }
        }

        return $this;
    }
}
