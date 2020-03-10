<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class SeriesController extends AbstractController
{
    /**
     * @Route("/series", name="series")
     */
    public function index(Request $request)
    {
        $pdo = $this->getDoctrine()->getManager();

        $serie = new Serie();

        $form = $this->createForm(SerieType::class, $serie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo->persist($serie);
            $pdo->flush();
        }

        $series = $pdo->getRepository(Serie::class)->findAll();

        return $this->render('series/index.html.twig', [
            'series' => $series,
            'form_ajout' => $form->createView(),
        ]);
    }

        /**
     * @Route("/series/{id}", name="edit_serie")
     */

    public function edit(Serie $serie, Request $request){

        $form = $this->createForm(SerieType::class, $serie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $pdo = $this->getDoctrine()->getManager();
            $pdo->persist($serie);
            $pdo->flush();
        }
        
        return $this->render('series/serie.html.twig', [
            'serie' => $serie,
            'form_edit' => $form->createView(),
            
        ]);
        

    }

    /**
     * @Route ("serie/delete/{id}", name="delete_serie")
     */

    public function delete(Serie $serie=null){

        if($serie !=null){

            $pdo = $this->getDoctrine()->getManager();
            $pdo->remove($serie);
            $pdo->flush();
        }
        return $this->redirectToRoute('series');
    }
}
