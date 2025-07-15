<?php

namespace Prolyfix\GoaBundle\Form;

use Prolyfix\GoaBundle\Form\DataTransformer\JsonTransformer;
use Prolyfix\GoaBundle\Entity\UntersuchungsCategory;
use Prolyfix\GoaBundle\Entity\UntersuchungsQuestion;
use Prolyfix\GoaBundle\Form\DataTransformer\PossibleResponseTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UntersuchungsQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('possibleResponse',TextType::class)
            ->add('untersuchungsAntworts', CollectionType::class, [
                'entry_type' => UntersuchungsAntwortType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
                        
            $builder
            ->get('possibleResponse')
            ->addModelTransformer(new PossibleResponseTransformer());
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {


        $resolver->setDefaults([
            'data_class' => UntersuchungsQuestion::class,
        ]);
    }
}
