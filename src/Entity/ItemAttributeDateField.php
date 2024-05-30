<?php

namespace App\Entity;

use App\Repository\ItemAttributeDateFieldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemAttributeDateFieldRepository::class)]
class ItemAttributeDateField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $value = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeDateFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryCollection $item = null;

    #[ORM\ManyToOne(inversedBy: 'itemAttributeDateFields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CustomAttribute $customItemAttribute = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?\DateTimeInterface
    {
        return $this->value;
    }

    public function setValue(\DateTimeInterface $value): static
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
