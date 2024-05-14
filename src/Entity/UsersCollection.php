<?php

namespace App\Entity;

use App\Repository\UsersCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersCollectionRepository::class)]
class UsersCollection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'usersCollection', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userName = null;

    /**
     * @var Collection<int, ItemCollection>
     */
    #[ORM\OneToMany(targetEntity: ItemCollection::class, mappedBy: 'collectionName', orphanRemoval: true)]
    private Collection $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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

    public function getUserName(): ?User
    {
        return $this->userName;
    }

    public function setUserName(User $userName): static
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return Collection<int, ItemCollection>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ItemCollection $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCollectionName($this);
        }

        return $this;
    }

    public function removeItem(ItemCollection $item): static
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getCollectionName() === $this) {
                $item->setCollectionName(null);
            }
        }

        return $this;
    }
}
