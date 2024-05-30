<?php

namespace App\Entity;

use App\Repository\ItemAttributeStringFieldRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemAttributeStringFieldRepository::class)]
class ItemAttributeStringField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeStringFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryCollection $item = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeStringFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CustomAttribute $customItemAttribute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getItem(): ?CategoryCollection
    {
        return $this->item;
    }

    public function setItem(?CategoryCollection $item): static
    {
        $this->item = $item;

        return $this;
    }

    public function getCustomItemAttribute(): ?CustomAttribute
    {
        return $this->customItemAttribute;
    }

    public function setCustomItemAttribute(?CustomAttribute $customItemAttribute): static
    {
        $this->customItemAttribute = $customItemAttribute;

        return $this;
    }
}
