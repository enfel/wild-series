<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Program;

/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() : Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', ['categories' => $categories]);


    }

    /**
     * @Route("/{categoryName}", name="show")
     */
    public function show(string $categoryName) : Response
    {
        $categoryRepository = $this->getDoctrine()->getRepository(Category::class);
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category named ' . $categoryName);
        }
        $programs = $this->getDoctrine()->getRepository(Program::class)->findBy(['category' => $category], ['id' => 'DESC'], 3);
        return $this->render('category/show.html.twig', ['programs' => $programs, 'categoryName'=>$categoryName]);
    }
}
