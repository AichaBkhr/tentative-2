<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Entity\Category;
use App\Form\ProduitType;
class ProduitController extends AbstractController
{
    
    public function index(int $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $en->getRepository(Produit::class)->findBy(['id' =>$id]);
        return $this->render('produit/index.html.twig', [
            'produit' => 'produit',
        ]);
    }

    public function edit(Request $request, int $id=null): Response
    {
        // Entity Manager de Symfony
        $em = $this->getDoctrine()->getManager();
        // Si un identifiant est présent dans l'url alors il s'agit d'une modification
        // Dans le cas contraire il s'agit d'une création d'article
        if($id) {
            $mode = 'update';
            // On récupère l'article qui correspond à l'id passé dans l'url
            $produit = $em->getRepository(Produit::class)->findBy(['id' => $id])[0];
        }
        else {
            $mode       = 'new';
            $produit    = new Produit();
        }

        $categories = $em->getRepository(Category::class)->findAll();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->saveProduit($produit, $mode);

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        $parameters = array(
            'form'      => $form->createView(),
            'produit'   => $produit,
            'mode'      => $mode
        );

        return $this->render('produit/edit.html.twig', $parameters);
    }

    
    public function remove(int $id): Response
    {
        /// Entity Manager de Symfony
        $em = $this->getDoctrine()->getManager();
        // On récupère l'article qui correspond à l'id passé dans l'URL
        $produit = $em->getRepository(Produit::class)->findBy(['id' => $id])[0];

        // L'article est supprimé
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute('homepage');
    }

    
    private function completeProduitBeforeSave(Produit $produit, string $mode) {
        if($produit->getEnPromo()){
            $produit->setPromoAt(new \DateTime());
        }
        $produit->setAuthor($this->getUser());

        return $produit;
    }

    private function saveProduit(Produit $produit, string $mode){
        $produit = $this->completeProduitBeforeSave($produit, $mode);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $this->addFlash('success', 'Enregistré avec succès');
    }
}
