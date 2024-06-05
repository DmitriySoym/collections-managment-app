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
        $this->itemAttributeIntegerFields = new ArrayCollection();
        $this->itemAttributeTextFields = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
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

    /**
     * @var Collection<int, ItemAttributeIntegerField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeIntegerField::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $itemAttributeIntegerFields;

    /**
     * @var Collection<int, ItemAttributeTextField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeTextField::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $itemAttributeTextFields;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $comments;

    /**
     * @var Collection<int, Like>
     */
    #[ORM\OneToMany(targetEntity: Like::class, mappedBy: 'item', orphanRemoval: true)]
    private Collection $likes;

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

    /**
     * @return Collection<int, ItemAttributeIntegerField>
     */
    public function getItemAttributeIntegerFields(): Collection
    {
        return $this->itemAttributeIntegerFields;
    }

    public function addItemAttributeIntegerField(ItemAttributeIntegerField $itemAttributeIntegerField): static
    {
        if (!$this->itemAttributeIntegerFields->contains($itemAttributeIntegerField)) {
            $this->itemAttributeIntegerFields->add($itemAttributeIntegerField);
            $itemAttributeIntegerField->setItem($this);
        }

        return $this;
    }

    public function removeItemAttributeIntegerField(ItemAttributeIntegerField $itemAttributeIntegerField): static
    {
        if ($this->itemAttributeIntegerFields->removeElement($itemAttributeIntegerField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeIntegerField->getItem() === $this) {
                $itemAttributeIntegerField->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemAttributeTextField>
     */
    public function getItemAttributeTextFields(): Collection
    {
        return $this->itemAttributeTextFields;
    }

    public function addItemAttributeTextField(ItemAttributeTextField $itemAttributeTextField): static
    {
        if (!$this->itemAttributeTextFields->contains($itemAttributeTextField)) {
            $this->itemAttributeTextFields->add($itemAttributeTextField);
            $itemAttributeTextField->setItem($this);
        }

        return $this;
    }

    public function removeItemAttributeTextField(ItemAttributeTextField $itemAttributeTextField): static
    {
        if ($this->itemAttributeTextFields->removeElement($itemAttributeTextField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeTextField->getItem() === $this) {
                $itemAttributeTextField->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setItem($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getItem() === $this) {
                $comment->setItem(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setItem($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getItem() === $this) {
                $like->setItem(null);
            }
        }

        return $this;
    }
}
