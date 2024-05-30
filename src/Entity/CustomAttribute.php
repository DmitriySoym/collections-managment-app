<?php

namespace App\Entity;

use App\Repository\CustomAttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\CustomAttributeType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomAttributeRepository::class)]
class CustomAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(min:3,max: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10, enumType: CustomAttributeType::class)]
    private ?CustomAttributeType $type = null;

    #[ORM\ManyToOne(inversedBy: 'customAttributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, ItemAttributeStringField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeStringField::class, mappedBy: 'customItemAttribute')]
    private Collection $itemAttributeStringFields;

    /**
     * @var Collection<int, ItemAttributeBooleanField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeBooleanField::class, mappedBy: 'customItemAttribute', orphanRemoval: true)]
    private Collection $itemAttributeBooleanFields;

    /**
     * @var Collection<int, ItemAttributeDateField>
     */
    #[ORM\OneToMany(targetEntity: ItemAttributeDateField::class, mappedBy: 'customItemAttribute', orphanRemoval: true)]
    private Collection $itemAttributeDateFields;

    public function __construct()
    {
        $this->itemAttributeStringFields = new ArrayCollection();
        $this->itemAttributeBooleanFields = new ArrayCollection();
        $this->itemAttributeDateFields = new ArrayCollection();
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

    public function getType(): ?CustomAttributeType
    {
        return $this->type;
    }

    public function setType(CustomAttributeType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

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
            $itemAttributeStringField->setCustomItemAttribute($this);
        }

        return $this;
    }

    public function removeItemAttributeStringField(ItemAttributeStringField $itemAttributeStringField): static
    {
        if ($this->itemAttributeStringFields->removeElement($itemAttributeStringField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeStringField->getCustomItemAttribute() === $this) {
                $itemAttributeStringField->setCustomItemAttribute(null);
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
            $itemAttributeBooleanField->setCustomItemAttribute($this);
        }

        return $this;
    }

    public function removeItemAttributeBooleanField(ItemAttributeBooleanField $itemAttributeBooleanField): static
    {
        if ($this->itemAttributeBooleanFields->removeElement($itemAttributeBooleanField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeBooleanField->getCustomItemAttribute() === $this) {
                $itemAttributeBooleanField->setCustomItemAttribute(null);
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
            $itemAttributeDateField->setCustomItemAttribute($this);
        }

        return $this;
    }

    public function removeItemAttributeDateField(ItemAttributeDateField $itemAttributeDateField): static
    {
        if ($this->itemAttributeDateFields->removeElement($itemAttributeDateField)) {
            // set the owning side to null (unless already changed)
            if ($itemAttributeDateField->getCustomItemAttribute() === $this) {
                $itemAttributeDateField->setCustomItemAttribute(null);
            }
        }

        return $this;
    }
}
