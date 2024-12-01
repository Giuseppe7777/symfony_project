<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\Todo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;  width:38%']
            ])
            ->add('priority', ChoiceType::class, [
                'choices'=>[
                    'Low' => 'Low',
                    'Normal' => 'Normal',
                    'High' => 'High',
                ],
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;  width:38%']
            ])
            ->add('image', FileType::class, [
                'label' => 'Image (png, jpg, jpeg file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image document',
                    ])
                ],
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px; width:38%']
            ])
            ->add('dueDate', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;  width:20%']
            ])
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;  width:20%']
            ])
            ->add('fk_status', EntityType::class, [
                'class' => Status::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose status',
                'attr' => ['class' => 'form-control', 'style' => 'margin-bottom:15px;  width:15%']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
