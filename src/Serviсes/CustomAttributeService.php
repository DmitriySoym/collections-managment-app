<?php

namespace App\Serviсes;
use App\Entity\CustomAttribute;

use App\Repository\CategoryCollectionRepository;
use App\Repository\CustomAttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\CategoryCollection;
use App\Entity\Category;
use App\Enum\CustomAttributeType;
use App\Entity\ItemAttributeBooleanField;
use App\Entity\ItemAttributeDateField;
use App\Entity\ItemAttributeIntegerField;
use App\Entity\ItemAttributeStringField;
use App\Entity\ItemAttributeTextField;

class CustomAttributeService extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CustomAttributeRepository $cr,
        private CategoryCollectionRepository $ccr
    ) {}

    public function setItemCustomAttributes(Category $itemsCollection, int|null $itemId): CategoryCollection {
        $item = $itemId ? $this->ccr->find($itemId) : new CategoryCollection();

        $customAttributes = $itemsCollection->getCustomAttributes()->getValues();
        foreach ($customAttributes as $customAttribute) {
            switch ($customAttribute->getType())
            {
                case CustomAttributeType::String:
                    $item = $this->setStringAttributes($item, $customAttribute);
                    break;
                case CustomAttributeType::Integer:
                    $item = $this->setIntegerAttributes($item, $customAttribute);
                    break;
                case CustomAttributeType::Text:
                    $item = $this->setTextAttributes($item, $customAttribute);
                    break;
                case CustomAttributeType::Boolean:
                    $item = $this->setBooleanAttributes($item, $customAttribute);
                    break;
                case CustomAttributeType::Date:
                    $item = $this->setDateAttributes($item, $customAttribute);
                    break;
            }
        }
        return $item;
    }

    private function setIntegerAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeInteger = new ItemAttributeIntegerField();
        $itemAttributeInteger->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeIntegerField($itemAttributeInteger);
        $this->em->persist($itemAttributeInteger);

        return $item;
    }

    private function setStringAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeString = new ItemAttributeStringField();
        $itemAttributeString->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeStringField($itemAttributeString);
        $this->em->persist($itemAttributeString);

        return $item;
    }

    private function setBooleanAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeBoolean = new ItemAttributeBooleanField();
        $itemAttributeBoolean->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeBooleanField($itemAttributeBoolean);
        $this->em->persist($itemAttributeBoolean);

        return $item;
    }

    private function setDateAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeDate = new ItemAttributeDateField();
        $itemAttributeDate->setCustomItemAttribute($customAttributeValue);
        $itemAttributeDate->setValue(new \DateTime());
        $item->addItemAttributeDateField($itemAttributeDate);
        $this->em->persist($itemAttributeDate);

        return $item;
    }

    private function setTextAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeText = new ItemAttributeTextField();
        $itemAttributeText->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeTextField($itemAttributeText);
        $this->em->persist($itemAttributeText);

        return $item;
    }
}
