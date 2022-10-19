<?php

namespace App\Controller;

use App\Entity\Animal;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnimauxController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $manager
    ){}

    #[Route('/animaux', name: 'app_animaux')]
    public function index(): Response
    {
        $animaux = $this->manager->getRepository(Animal::class)->findAll();

        return $this->render('animaux/index.html.twig', [
            'animaux' => $animaux,
        ]);
    }

    #[Route('/animaux/{id}', name:'show_animaux', methods:['GET'], requirements:['id' => "\d+"])]
    public function show(int $id): Response
    {
        $animaux = $this->manager->getRepository(Animal::class)->find($id);
        if (!$animaux) {
            return $this->redirectToRoute('app_animaux');
        }
        return $this->render('animaux/show.html.twig', [
            'animaux' => $animaux
        ]);
    }

}
