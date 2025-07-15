<?php

namespace Prolyfix\GoaBundle\Form;

use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\UntersuchungsAntwort;
use Prolyfix\GoaBundle\Entity\UntersuchungsQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UntersuchungsAntwortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('response')
            ->add('sequences', EntityType::class, [
                'class' => Sequence::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
            ->add('numbers', EntityType::class, [
                'class' => Number::class,
                'choice_label' => 'number',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UntersuchungsAntwort::class,
        ]);
    }
}
