<?php

namespace App\Controller;

use App\Form\CategoryType;
use Doctrine\Common\Persistence\ObjectManager;
use Proxies\__CG__\App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
	/**
	 * Show all row from article's entity
	 *
	 * @Route("/addCategorie", name="add_category")
	 */
	public function addCategorie(Request $request, ObjectManager $manager) : Response
	{
		$categorie = new Categorie();
		$form = $this->createForm(CategoryType::class, $categorie);
		
		$form->handleRequest($request);
		//soumission et préparation
		if ($form->isSubmitted()) {
			$data = $form->getData();
			$manager->persist($data);
			$manager->flush();
			// $data contient les données du $_POST
			// Faire une recherche dans la BDD avec les infos de $data...
		}
		
		return $this->render(
			'blog/addCategorie.html.twig', [
				'form' => $form->createView()
			]
		);
	}
}