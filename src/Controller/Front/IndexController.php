<?php

declare(strict_types=1);

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hotel;
use Doctrine\ORM\EntityManagerInterface;

class IndexController extends AbstractController 
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    public function __construct(
            \Twig\Environment $twig,
            EntityManagerInterface $entityManager
    ) 
    {
        $this->twig = $twig;
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/")
     */
    public function index() 
    {
        $hotelData = $this->entityManager->getRepository('App\Entity\Hotel')->findAll();
        $html = $this->twig->render('index.html.twig',
                [
                    'hotelData' => $hotelData
                ]
        );
        return new Response($html);
    }

}
