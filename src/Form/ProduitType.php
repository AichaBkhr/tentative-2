<?php
 
namespace App\Form;

use App\Entity\Produit;
use App\Entity\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Titre
        $builder->add('libelle', TextType::class, [
            'label' => 'Libellé*',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        // Catégorie
        $builder->add('categorie', TextType::class, [
            'label' => 'Catégorie*',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        // Prix
        $builder->add('prix', TextType::class, [
            'label' => 'Prix*',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        // En promotion
        // Statut
        $builder->add('EnPromo', CheckboxType::class, [
            'label' => 'Mettre en promotion le produit'
        ]);


        //remise
        $builder->add('remise', TextType::class, [
            'label' => 'Remise*',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        //remise
        $builder->add('datefin', TextType::class, [
            'label' => 'Date de fin de promo*',
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut être vide'
                ])
            ]
        ]);

        // descr
        $builder->add('description', TextareaType::class, [
            'label' => 'Description du produit'
        ]);

        

        // Bouton Envoyer
        $builder->add('submit', SubmitType::class, array(
            'label' => 'Enregistrer'
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }

}