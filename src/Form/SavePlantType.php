<?php

namespace App\Form;

use App\Entity\Plant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SavePlantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('commonName')
            ->add('scientificName')
            ->add('watering')
            ->add('wateringSmall')
            ->add('exposure')
            ->add('exposureSmall')
            ->add('soil')
            ->add('family')
            ->add('disease')
            ->add('repotting')
            ->add('repottingSmall')
            ->add('humidity')
            ->add('temperature')
            ->add('temperatureNumber')
            ->add('confidence')
            ->add('description')
            ->add('plantingPeriod')
            ->add('plantingDistance')
            ->add('fertilizer')
            ->add('height')
            ->add('width')
            ->add('foliage')
            ->add('foliageType')
            ->add('shape')
            ->add('flowers')
            ->add('bloomPeriod')
            ->add('fruits')
            ->add('toxicity')
            ->add('careTips')
            ->add('isSafeGuess')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Plant::class,
        ]);
    }
}
