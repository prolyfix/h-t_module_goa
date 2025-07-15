<?php

namespace Prolyfix\GoaBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Prolyfix\GoaBundle\Entity\Sequence;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Prolyfix\GoaBundle\Form\IgelType;
use Prolyfix\GoaBundle\Form\ImporterType;
use Prolyfix\GoaBundle\Form\SequenceEntryType;
use Prolyfix\GoaBundle\Manager\SequenceParser;
use Prolyfix\ProcurementBundle\Form\ComparisonType;
use Prolyfix\ProcurementBundle\Helper\SequenceToArray;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;

class SequenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sequence::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            CollectionField::new('sequenceEntries')->setEntryType(SequenceEntryType::class)->setFormTypeOption('by_reference', false),
        ];
    }

    public function compareSequences(SequenceParser $sequenceParser, Request $request)
    {
        $form = $this->createForm(ComparisonType::class);
        $form->handleRequest($request);
        $outputSequenceA = [];
        $outputSequenceB  = [];
        $keys = [];
        if($form->isSubmitted() and $form->isValid()){
            $sequenceString = $form->get('entrySequence')->getData();
            $defaultFactor = $form->get('defaultFactor')->getData();
            $sequenceA = $sequenceParser->parseSequence($sequenceString, $defaultFactor);
            $sequences = $form->get('compareSequence')->getData();
            $sequenceB = new Sequence();
            foreach($sequences as $sequence){
                foreach($sequence->getSequenceEntries() as $sequenceEntry){
                    $sequenceB->addSequenceEntry($sequenceEntry);
                }
            }

            $outputSequenceA = SequenceToArray::sequenceToArray($sequenceA);
            $outputSequenceB = SequenceToArray::sequenceToArray($sequenceB);

            $keys = array_keys($outputSequenceA + $outputSequenceB);
        }
        return $this->render('@ProlyfixGoaBundle/sequence/compare.html.twig',[
            'form' => $form->createView(),
            'outputSequenceA' => $outputSequenceA,
            'outputSequenceB' => $outputSequenceB,
            'keys' => $keys
        ]);
    }

    public function import(Request $request, SequenceParser $sequenceParser, EntityManagerInterface $em)
    {
        $form = $this->createForm(ImporterType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $sequenceString = $form->get('entrySequence')->getData();
            $defaultFactor = $form->get('defaultFactor')->getData();
            $sequence = $sequenceParser->parseSequence($sequenceString, $defaultFactor);
            $sequence->setName($form->get('name')->getData());
            $em->persist($sequence);
            $em->flush();

        }
        return $this->render('@ProlyfixGoaBundle/sequence/importer.html.twig',
        [
            'form' => $form->createView(),
        ]
    
    );
    }

    public function configureActions(Actions $actions): Actions
    {
        $importAction = Action::new('import', 'Import Sequence')
            ->linkToCrudAction('import');
            return $actions
            ->add(Crud::PAGE_INDEX, $importAction);
    }

    public function iGelPrice (Request $request, ParameterBagInterface $parameterBag)
    {
        $form = $this->createForm(IgelType::class);
        $pointValue = $parameterBag->get('igel_point_value') * 1 ;
        $increment = $parameterBag->get('igel_increment') * 1;
        $sequence = new Sequence();
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $sequence = $form->get('compareSequence')->getData();
            $targetPrice = $form->get('targetPrice')->getData();
            // let everything to the min factor;
            $sequence->setToMinFactor();
            if($sequence->getTotalPoints($pointValue) * $pointValue > $targetPrice){
                $this->addFlash('warning', 'The price is already above the target price');
            }else{
                $achieved = false;
                
                // we check now the price with the increment
                while($achieved == false){
                    $achieved = true;
                    $finished = false;
                    foreach($sequence->getSequenceEntries() as $sequenceEntry){
                        if($sequenceEntry->getFactor() < $sequenceEntry->getNumber()->getFactorAverage()){
                            $sequenceEntry->setFactor($sequenceEntry->getFactor() + $increment);
                            $achieved =  false;
                        }
                        else
                            $achieved = $achieved && true;
                    }   
                    if($sequence->getTotalPoints($pointValue) * $pointValue > $targetPrice){
                        $achieved = true;
                        $finished = true;
                    }
                }
                if(!$finished){
                    $achieved = false;
                
                    // we check now the price with the increment
                    while($achieved == false){
                        $achieved = true;
                        foreach($sequence->getSequenceEntries() as $sequenceEntry){
                            if($sequenceEntry->getFactor() < $sequenceEntry->getNumber()->getFactorMax()){
                                $sequenceEntry->setFactor($sequenceEntry->getFactor() + $increment);
                                $achieved =  false;
                            }
                            else
                                $achieved = $achieved && true;
                        }   
                        if($sequence->getTotalPoints($pointValue) * $pointValue > $targetPrice){
                            $achieved = true;
                        }
                    }
                }
            }
        }
        return $this->render('@ProlyfixGoaBundle/sequence/igel.html.twig',
        [
            'form' => $form->createView(),
            'sequence' => $sequence,
            'pointValue' => $pointValue,
        ]
    
    );
    }

    
}
