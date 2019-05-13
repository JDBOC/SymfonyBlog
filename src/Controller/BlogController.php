<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BlogController extends AbstractController
{
     /**
     * @Route("/blog/show/{slug}", methods={"GET"}, defaults={"slug"="article sans titre"}, name="blog_show")
     */
    public function show($slug)
    {
        $str = str_replace('-', ' ', $slug);
        $str = ucwords($str);
        return $this->render('blog/show.html.twig', ['slug' => $str]);
    }
}