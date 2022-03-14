<?php

namespace App\Form;

use App\Entity\PhoneModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brand',
                TextType::class,[
                    'label' => 'Marque',
                    'attr' => [
                        'placeholder'=>'Marque du téléphone'
                    ]])
            ->add('model',
                TextType::class,[
                    'label' => 'Modèle',
                    'attr' => [
                        'placeholder'=>'Modèle du téléphone'
                    ]])
            ->add('year',
                TextType::class, [
                    'label' => 'Année de création',
                    'required'   => false,
                    'attr' => [
                        'placeholder'=>'Année de création',

                    ]])
            ->add('description',
                TextareaType::class,[
                    'label' => 'Descriptif',
                    'required'   => false,
                    'attr' => [
                        'placeholder'=>'Descriptif',


                    ]])
            ->add('stock',
                IntegerType::class,[
                    'label'=> 'Valeur de stock',
                    'constraints' => [new PositiveOrZero()],
                    'required'   => false,
                    'attr' => [
                        'placeholder' => 'Valeur de stock',

                    ]
                ])
            ->add('stockLimit',
                IntegerType::class,[
                    'label'=> 'Valeur limite de stock',
                    'constraints' => [new PositiveOrZero()],
                    'empty_data' => '0',
                    'required'   => false,
                    'attr' => [

                        'placeholder' => 0,


                    ]
                ])
            ->add(
                'idNumbers',
                CollectionType::class,
                [
                    'label' => " ",
                    'entry_type' => IdNumberType::class,
                    'allow_add' =>true,
                    'allow_delete' =>true,
                    'prototype' => true,
                    'by_reference' => false
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PhoneModel::class,
        ]);
    }
}
