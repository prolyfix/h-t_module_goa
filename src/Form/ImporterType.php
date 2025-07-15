<?php
namespace Prolyfix\GoaBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImporterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',null,['attr' => ['class' => 'form-control']])
            ->add('defaultFactor',ChoiceType::class,['attr' => ['class' => 'form-control'],'choices'=>[1=>1,'Schwellenwert'=>'Schwellenwert','Grenzwert'=>'Grenzwert']])
            ->add('entrySequence',null,['attr' => ['class' => 'form-control']])
            ->add('submit',SubmitType::class,['attr' => ['class' => 'btn btn-primary mt2']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}