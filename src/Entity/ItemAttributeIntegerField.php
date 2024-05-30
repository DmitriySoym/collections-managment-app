<?php

namespace App\Entity;

use App\Repository\ItemAttributeIntegerFieldRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemAttributeIntegerFieldRepository::class)]
class ItemAttributeIntegerField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeIntegerFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryCollection $item = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeIntegerFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CustomAttribute $customItemAttribute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
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
