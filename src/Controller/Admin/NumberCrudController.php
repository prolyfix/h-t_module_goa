<?php

namespace Prolyfix\GoaBundle\Controller\Admin;

use Prolyfix\GoaBundle\Entity\Number;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Prolyfix\GoaBundle\Form\RelatedNumberType;

class NumberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Number::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('number'),
            TextField::new('description'),
            TextField::new('myDescription'),
            NumberField::new('fixedPrice'),
            IntegerField::new('points'),
            NumberField::new('factorAverage'),
            NumberField::new('factorMax'),
            TextEditorField::new('comment'),
            CollectionField::new('relatedNumbers')->setEntryType(RelatedNumberType::class)->hideOnIndex()->setFormTypeOption('by_reference', false),
        ];
    }
    
}
