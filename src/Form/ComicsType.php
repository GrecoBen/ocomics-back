<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Comics;
use App\Entity\Characters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ComicsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre du comics",
                "attr" => [
                    "placeholder" => "Superman n°42"
                ]
            ])
            ->add('poster', UrlType::class, [
                "label" => "URL de l'image de couverture",
                "attr" => [
                    "placeholder" => "Entrer ici l'URL de l'image qui sera affiché"
                ]
            ])
            ->add('released_at', DateTimeType::class, [
                'label' => 'Année de sortie',
                "widget" => "single_text",
                "input" => "datetime_immutable",
            ])
            ->add('synopsis', TextType::class, [
                "label" => "synopsis",
                "attr" => [
                    "placeholder" => "Après avoir arrêté le bouffon vert, ..."
                ]
            ])
            ->add('rarity', ChoiceType::class, [
                "label" => "Rareté du comics",
                "choices" => [
                    "Collector" => 5,
                    "Très rare" => 4,
                    "Rare" => 3,
                    "Inhabituel" => 2,
                    "Commun" => 1
                ],
                "expanded" => true
            ])
            ->add('author', EntityType::class, [
                "class" => Author::class,
                "label" => "Auteur du comics",
                "expanded" => true,
                "choice_label" => "lastname"
            ])
            ->add('characters', EntityType::class, [
                "class" => Characters::class,
                "label" => "Personnages",
                "expanded" => true,
                "multiple" => true,
                "choice_label" => "name"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comics::class,
        ]);
    }
}
