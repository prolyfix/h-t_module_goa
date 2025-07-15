<?php

namespace Prolyfix\GoaBundle\Form;

use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\RelatedNumber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelatedNumberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relation')
            ->add('targteNumber', EntityType::class, [
                'class' => Number::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RelatedNumber::class,
        ]);
    }
}
