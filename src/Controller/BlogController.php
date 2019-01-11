<?php
namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="blog_index")
     */
    public function index(Request $request)
    {
       $html = $this->twig->render('base.html.twig',
           [

           ]);
       return new Response($html);
    }
}
