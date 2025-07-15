<?php

namespace Prolyfix\GoaBundle\Form;

use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\SequenceEntry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SequenceEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('factor')
            ->add('comment')
            ->add('number', EntityType::class, [
                'class' => Number::class,
                'choice_label' => 'number',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SequenceEntry::class,
        ]);
    }
}
