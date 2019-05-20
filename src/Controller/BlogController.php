<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;



class BlogController extends AbstractController
{
	
	/**
	 * Getting a article with a formatted slug for title
	 *
	 * @param string $slug The slugger
	 *
	 * @Route("/blog/show/{slug<^[a-z0-9-]+$>}",
	 *     defaults={"slug" = null},
	 *     name="blog_show")
	 *  @return Response A response instance
	 */
	public function show(?string $slug): Response
	{
		if (!$slug) {
			throw $this
				->createNotFoundException('No slug has been sent to find an article in article\'s table.');
		}
		
		$slug = preg_replace(
			'/-/',
			' ',
			ucwords(trim(strip_tags($slug)), "-")
		);
		
		$article = $this->getDoctrine()
			->getRepository(Article::class)
			->findOneBy(['title' => mb_strtolower($slug)]);
		
		if (!$article) {
			throw $this->createNotFoundException(
				'No article with ' . $slug . ' title, found in article\'s table.'
			);
		}
		
		return $this->render(
			'blog/show.html.twig',
			[
				'article' => $article,
				'slug' => $slug,
			]
		);
	}
	
	/**
	 * Show all row from article's entity
	 *
	 * @Route("/", name="blog_index")
	 * @return Response A response instance
	 */
	public function index(): Response
	{
		$articles = $this->getDoctrine()
			->getRepository(Article::class)
			->findAll();
		
		if (!$articles) {
			throw $this->createNotFoundException(
				'No article found in article\'s table.'
			);
			
		}
		return $this->render(
			'blog/index.html.twig', [
				'articles' => $articles
				
			]
		);
		}
	


    

    // public function showByCategory(string $categorieName)
    //{
    //    $categorie = $this->getDoctrine()
    //                        ->getRepository(Categorie::class)
    //->findOneBy(['name' => $categorieName]);
    //
    //    $articles = $this->getDoctrine()
    //    ->getRepository(Article::class)
    //    ->findBy(['categorie' => $categorie], ['id' => 'DESC'], 3);
    //
    //if (!$articles) {
    //    throw $this->createNotFoundException(
    //    'No article found in article\'s table.'
    //    );
    //}
    //
    //return $this->render(
    //        'blog/category.html.twig',
    //        ['articles' => $articles]
    //);
    //}
    //

   // /**
   //  * Show all row from article's entity
   //  *
   //  * @Route("category/{categorieName}",
   //  * defaults={"categorieName" = "Javascript"},
   //  * name="show_categorie")
   //  * @return Response A response instance
   //  */
   // public function showByCategory(string $categorieName)
   // {
   //     $categorie = $this->getDoctrine()
   //         ->getRepository(Categorie::class)
   //         ->findOneBy(['name' => $categorieName]);
   //     $articles = $categorie->getArticles();
//
   //     return $this->render(
   //         'blog/category.html.twig',
   //         [
   //             'articles' => $articles,
   //             'categorie' => $categorieName
   //         ]
   //     );
   // }
	/**
	 * @Route("/category/{name}", name="article_show")
	 */
	public function showByCategory(categorie $categorie): Response
	{
		$article = $categorie->getArticles();
		return $this->render(
		        'blog/category.html.twig',
		        [
		            'article' => $article,
		            'categorie' => $categorie
		        ]
		     );
	}
	
	
	
}
