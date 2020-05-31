<?php

namespace App\Form;

use App\Entity\Commentaires;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CommentaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre pseudo'
                ]
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => ' ',
                'attr' => [
                    'class' => 'textAreaComment',
                    'placeholder' => 'Votre commentaires…'
                ]
            ])
            ->add('rgpd', CheckboxType::class, [
                'label' => 'Je confirme l\'ajout du commentaire'
            ])
            ->add('Ajouter', SubmitType::class, [
                'attr' => [
                    'class' => 'mt-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
