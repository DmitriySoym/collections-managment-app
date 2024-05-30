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

    public function __construct()
    {
        $this->itemAttributeStringFields = new ArrayCollection();
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
}
