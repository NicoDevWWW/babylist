<?php

namespace App\Controller;

use App\Entity\Liste;
use App\Form\ListeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateListeController extends AbstractController
{
    /**
     * @Route("/create/liste", name="create_liste")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

		$user = $this->getUser();
		if ($user){
			$liste = new Liste();
			$listeForm = $this->createForm(ListeType::class, $liste);
			$listeForm->handleRequest($request);
			if ($listeForm->isSubmitted() ){
				//if forms list is valid
				if ($listeForm->isValid()){
					//Get user for liste and set Owner_id
					$liste->setOwner( $this->getUser());
					$entityManager->persist($liste);
					$entityManager->flush();
					return $this->redirectToRoute("liste", ["id"=>$liste->getId()]);
				}else{
					dump('Not valid Malin');
				}


			}
		}else{
			echo "Redirect to another route";
		}
        return $this->render('create_liste/index.html.twig', [
            'listeform' => $listeForm->createView()
        ]);
    }
}
