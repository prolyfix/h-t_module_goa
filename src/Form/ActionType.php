<?php

namespace Prolyfix\GoaBundle\Form;

use Prolyfix\GoaBundle\Entity\Number;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\UntersuchungsCategory;
use Prolyfix\GoaBundle\Entity\UntersuchungsQuestion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $action = $event->getData();
            $builder = $event->getForm();
            if($action == null){
                return;
            }
            $builder->add('response',null,['attr' => ['class' => 'form-control'],'mapped'=>false,'data'=>$action["response"]]);
        });
        $builder
            ->add('response',null,['attr' => ['class' => 'form-control'],'mapped'=>false])
            ->add('sequence',EntityType::class,['attr' => ['class' => 'form-control'],'class'=>Sequence::class,'choice_label'=>'name','multiple'=>true,'mapped'=>false])    
            ->add('number',EntityType::class,['attr' => ['class' => 'form-control'],'class'=>Number::class,'choice_label'=>'number','multiple'=>true,'mapped'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
