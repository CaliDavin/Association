<?php
namespace App\Controller;

use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    public function __construct(
        private ManagerRegistry $manager
    ){}

    #[Route("/", name:"app_home", methods:["GET"])]
    public function home(AnimalRepository $animalRepository): Response
    {
        $date = date('Y-m-d h:i:s', strtotime("-30 days"));
        $animaux = $animalRepository->createQueryBuilder('a')
                ->where('a.createdAt BETWEEN :n30days AND :today')
                ->setParameter('today', date('Y-m-d h:i:s'))
                ->setParameter('n30days', $date)
                ->getQuery()
                ->getResult();
            ;

        return $this->render('home.html.twig', [
            'animaux' => $animaux,
        ]);
    }
}