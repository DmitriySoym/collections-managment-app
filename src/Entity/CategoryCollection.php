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

    public function __construct()
    {
        // $this->categotyId = $collection;
        $this->itemAttributeStringFields = new ArrayCollection();
        $this->itemAttributeBooleanFields = new ArrayCollection();
        $this->itemAttributeDateFields = new ArrayCollection();
    }
    //  entity for collection item
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
     * @var Collection<int, ItemAttributeStringField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeStringField::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $itemAttributeStringFields;

    /**
     * @var Collection<int, ItemAttributeBooleanField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeBooleanField::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $itemAttributeBooleanFields;

    /**
     * @var Collection<int, ItemAttributeDateField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeDateField::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $itemAttributeDateFields;

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
     * @return Collection<int, ItemAttributeStringField>
     */
    public function getItemAttributeStringFields(): Collection
    {
        return $this->itemAttributeStringFields;
    }

    public function addItemAttributeStringField(ItemAttributeStringField $itemAttributeStringField): static
    {
        if (!$this->itemAttributeStringFields->contains($itemAttributeStringField)) {
            $this->itemAttributeStringFields->add($itemAttributeStringField);
            $itemAttributeStringField->setItem($this);
        }

        return $this;
    }

    public function removeItemAttributeStringField(ItemAttributeStringField $itemAttributeStringField): static
    {
        if ($this->itemAttributeStringFields->removeElement($itemAttributeStringField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeStringField->getItem() === $this) {
                $itemAttributeStringField->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemAttributeBooleanField>
     */
    public function getItemAttributeBooleanFields(): Collection
    {
        return $this->itemAttributeBooleanFields;
    }

    public function addItemAttributeBooleanField(ItemAttributeBooleanField $itemAttributeBooleanField): static
    {
        if (!$this->itemAttributeBooleanFields->contains($itemAttributeBooleanField)) {
            $this->itemAttributeBooleanFields->add($itemAttributeBooleanField);
            $itemAttributeBooleanField->setItem($this);
        }

        return $this;
    }

    public function removeItemAttributeBooleanField(ItemAttributeBooleanField $itemAttributeBooleanField): static
    {
        if ($this->itemAttributeBooleanFields->removeElement($itemAttributeBooleanField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeBooleanField->getItem() === $this) {
                $itemAttributeBooleanField->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemAttributeDateField>
     */
    public function getItemAttributeDateFields(): Collection
    {
        return $this->itemAttributeDateFields;
    }

    public function addItemAttributeDateField(ItemAttributeDateField $itemAttributeDateField): static
    {
        if (!$this->itemAttributeDateFields->contains($itemAttributeDateField)) {
            $this->itemAttributeDateFields->add($itemAttributeDateField);
            $itemAttributeDateField->setItem($this);
        }

        return $this;
    }

    public function removeItemAttributeDateField(ItemAttributeDateField $itemAttributeDateField): static
    {
        if ($this->itemAttributeDateFields->removeElement($itemAttributeDateField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeDateField->getItem() === $this) {
                $itemAttributeDateField->setItem(null);
            }
        }

        return $this;
    }
}
