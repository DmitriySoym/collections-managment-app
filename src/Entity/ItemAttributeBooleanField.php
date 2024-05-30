<?php

namespace App\Entity;

use App\Repository\ItemAttributeBooleanFieldRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemAttributeBooleanFieldRepository::class)]
class ItemAttributeBooleanField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $value = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeBooleanFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryCollection $item = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeBooleanFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CustomAttribute $customItemAttribute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isValue(): ?bool
    {
        return $this->value;
    }

    public function setValue(bool $value): static
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
