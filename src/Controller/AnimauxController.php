<?php

namespace App\Controller;

use DateTime;
use App\Entity\Animal;
use App\Form\AnimalType;
use App\Service\UploadFile;
use App\Repository\AnimalRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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


    #[Route('/animaux/add', name:'add_animaux', methods:["GET", "POST"])]
    public function add(Request $request): Response
    {
        $animaux = new Animal;
        // $this->createFormBuilder() permet de créer un générateur de formulaire
        // $form = $this->createFormBuilder($category)
        //    // On utilise la méthode add pour ajouter des champs à notre formulaire
        //     ->add('name', TextType::class, [
        //         'label' => "Nom de la catégorie",
        //         'attr' => [
        //             'placeholder' => "Nom de la catégorie"
        //         ],
        //         'row_attr' => [
        //             'class' => 'mb-3 form-floating'
        //         ]
        //     ])
        //     ->add('button', SubmitType::class, [
        //         'label' => "Ajouter"
        //     ])
        //     // La méthode getForm permet de récupérer le formulaire généré
        //     ->getForm()
        // ;
        $form = $this->createForm(AnimalType::class, $animaux);
        // handleRequest() récupère les informations reçues du formulaire
        // et stockée dans la Request pour les associer à l'entité Category
        // passée en data du createFormBuilder
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture = $form->get('photo')->getData();
            if ($picture) {
                try {
                    $pictureName = md5(uniqid()). '.' . $picture->guessExtension();
                    // Permet de déplacer l'image dans un dossier d'upload
                    // move() prend 2 paramètres: le dossier d'upload et le nom du fichier
                    $picture->move(
                        $this->getParameter('upload_dir'),
                        $pictureName
                    );
                    $animaux->setPhoto($pictureName);
                } catch (FileException $e) {
                    $this->addFlash('danger', "Une erreur s'est produite lors de l'enregistrement de l'image avec le message suivant: ". $e->getMessage());
                }
            }
            $animaux->setCreatedAt(new DateTime());
            $om = $this->manager->getManager();
            $om->persist($animaux);
            $om->flush();
            $this->addFlash('success', "L'animal ".$animaux->getName()." a été ajoutée");

            return $this->redirectToRoute('app_animaux');
        }

        // Lorsqu'on passe un formulaire à notre template,
        // On utilise la méthode renderForm plutôt que render
        // qui va appliquer la méthdoe createView() sur le form 
        // pour en générer l'affichage
        return $this->renderForm('animaux/add.html.twig', [
            // 'form' => $form->createView()
            'form' => $form
        ]);
    }

    #[Route('/{id}/update', name:'update', methods:['GET', 'POST'], requirements:['id' => "\d+"])]
    public function update(int $id, Request $request, AnimalRepository $animalRepository): Response
    {
        $animaux = $animalRepository->find($id);
        if (!$animaux) {
            $this->addFlash('danger', "L'animal que vous recherchez n'existe pas.");
            return $this->redirectToRoute('app_animaux');
        }

        $form = $this->createForm(AnimalType::class, $animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $picture = $form->get('photo')->getData();
            if ($picture) {
                try {
                    if ($animaux->getPhoto()) {
                        unlink($this->getParameter('upload_dir') .'/' . $animaux->getPhoto());
                    }
                    $pictureName = md5(uniqid()). '.' . $picture->guessExtension();
                    // Permet de déplacer l'image dans un dossier d'upload
                    // move() prend 2 paramètres: le dossier d'upload et le nom du fichier
                    $picture->move(
                        $this->getParameter('upload_dir'),
                        $pictureName
                    );
                    $animaux->setPhoto($pictureName);
                } catch (FileException $e) {
                    $this->addFlash('danger', "Une erreur s'est produite lors de l'enregistrement de l'image avec le message suivant: ". $e->getMessage());
                }
            }

            $animalRepository->save($animaux, true);
            $this->addFlash('success', "L'article a été modifié.");
            return $this->redirectToRoute('app_animaux');
        }

        return $this->renderForm("animaux/update.html.twig", [
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name:"delete", requirements:['id' => "\d+"])]
    public function delete(int $id, AnimalRepository $animalRepository): Response
    {
        $animaux = $animalRepository->find($id);
        if ($animaux) {
            $animalRepository->remove($animaux, true);
        } else {
            $this->addFlash('danger', "L'animal que vous recherchez n'existe pas.");
        }
        return $this->redirectToRoute('app_animaux');
    }
}
