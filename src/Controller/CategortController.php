<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategortController extends AbstractController
{
    #[Route('/admin/categort', name: 'app_categort')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('categort/index.html.twig', [
            'categories' => $categories
        ]);
    } 

    #[Route('/admin/categort/new', name: 'app_categort_new')]
    public function addCategort(EntityManagerinterface $entityManager, Request $request):Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Category created successfully');
            return $this->redirectToRoute('app_categort');
        }
        
        return $this-> render('categort/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/categort/{id}/update', name: 'app_categort_update')]
    public function update(Category $category, EntityManagerInterface $entityManager, Request $request):Response
    {
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();

            $this->addFlash('success', 'Category updated successfully');
            return $this->redirectToRoute('app_categort');
        }       

        return $this->render('categort/update.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/categort/{id}/delete', name: 'app_categort_delete')]
    public function delete(Category $category, EntityManagerInterface $entityManager):Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash('success', 'Category deleted successfully');
        return $this->redirectToRoute('app_categort');
    }

    
}
