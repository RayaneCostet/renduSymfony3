<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Serie;
use App\Form\CategoriesType;
use App\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function index(Request $request)
    {
        $pdo = $this->getDoctrine()->getManager();

        $categorie = new Categorie();

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo->persist($categorie);
            $pdo->flush();
        }

        $categories = $pdo->getRepository(Categorie::class)->findAll();

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
            'form_ajout' => $form->createView(),
        ]);
    }

        /**
     * @Route("/categories/{id}", name="edit_categorie")
     */

    public function edit(Categorie $categorie, Request $request){

        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->persist($categorie);
            $pdo->flush();
        }
        
        return $this->render('categories/categories.html.twig', [
            'categories' => $categorie,
            'form_edit' => $form->createView(),
            
        ]);
        

    }

    /**
     * @Route ("categorie/delete/{id}", name="delete_categorie")
     */

    public function delete(Categorie $categorie=null){

        if($categorie !=null){

            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($categorie);
            $pdo->flush();
        }
        return $this->redirectToRoute('categories');
    }
}
