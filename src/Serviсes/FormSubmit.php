<?php
namespace App\Serviсes;
use App\Entity\Category;
use App\Entity\CategoryCollection;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormSubmit extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr
    ) {}

    public function submitCategory(Category $category)
    {

            $category->setAuthor($this->getUser());
            $category->setUpdated(new \DateTime());
            $this->em->persist($category);
            $this->em->flush();
            $categoryName = $category->getName();

            // $this->addFlash('success', "Collection $categoryName created successfully");
    }

    public function submitCategoryItem(CategoryCollection $itemCollection, int $id)
    {
            $itemCollection->setCreated(new \DateTime());
            $itemCollection->setUpdated(new \DateTime());
            $itemCollection->setCategotyId($this->cr->find($id));
            $this->em->persist($itemCollection);
            $this->em->flush();

            $itemCollectionName = $itemCollection->getName();

            $this->addFlash('success', "Collection $itemCollectionName created successfully");
    }

    public function addComment($form, $itemCollection) 
    {
            $comment = $form->getData();
            $comment->setUser($this->getUser());
            $comment->setItem($itemCollection);
            $comment->setCreated(new \DateTime());
            $this->em->persist($comment);
            $this->em->flush();
    }
} 