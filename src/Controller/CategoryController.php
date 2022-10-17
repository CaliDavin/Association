<?php

namespace App\Controller;

use App\Entity\Category;
// use App\Entity\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    // public function index(CategoryRepository $repository): Response
    public function index(ManagerRegistry $manager): Response
    {
        // $categories = $repository->findAll(); // Symfony 4, on charge le Repository en paramètre et on l'utilise directement
        $categories = $manager->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
