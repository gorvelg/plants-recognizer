<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PlantUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('photo', FileType::class, [
                'label' => 'Télécharger une image',
                'row_attr' => [
                    'class' => 'input-download'
                ],
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File(
                        maxSize: '8M',
                        mimeTypes: [
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/webp',],
                        mimeTypesMessage: 'Merci d\'envoyer un fichier jpg, jpeg, webp'
                    )
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
