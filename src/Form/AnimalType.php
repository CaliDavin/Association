<?php

namespace App\Form;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class AnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => "Nom de l'animal",
            'attr' => [
                'placeholder' => "Nom de l'animal"
            ],
            'row_attr' => [
                'class' => 'mb-3 form-floating'
            ]
        ])
            ->add('type', TextType::class, [
                'label' => "Quel est l'animal ?",
                'attr' => [
                    'placeholder' => "exemple : chien/chat ..."
                ],
                'row_attr' => [
                    'class' => 'mb-3 form-floating'
                ]
            ])
            ->add('age', IntegerType::class, [
                'label' => "Âge",
                'attr' => [
                    'placeholder' => "exemple : chien/chat ..."
                ],
                'row_attr' => [
                    'class' => 'mb-3 form-floating'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => "Description",
                'attr' => [
                    'placeholder' => "Description de l'animal"
                ],
                'row_attr' => [
                    'class' => 'mb-3 form-floating'
                ]
            ])
            ->add('photo', FileType::class, [
                'label' => "Image de mise en avant (.png, .jpeg)",
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new File(
                        mimeTypes:["image/jpeg", "image/png"],
                        mimeTypesMessage:"L'image doit être au format jpeg ou png"
                    )
                ]
            ])
            ->add('genre', ChoiceType::class, [
                'label' => "Genre",
                'row_attr' => [
                    'class' => 'mb-3 form-floating'
                ],
                'choices' => [
                    "Male" => "Male",
                    "Femelle" => "Femelle"
                ]
            ])

            ->add('button', SubmitType::class, [
                'label' => "Modifier"
            ])
            ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
