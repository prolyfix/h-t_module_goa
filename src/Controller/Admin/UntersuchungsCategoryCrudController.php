<?php

namespace Prolyfix\GoaBundle\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Prolyfix\GoaBundle\Entity\UntersuchungsCategory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Prolyfix\GoaBundle\Form\UntersuchungsQuestionType;
use Symfony\Component\HttpFoundation\Request;

class UntersuchungsCategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UntersuchungsCategory::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            CollectionField::new('UntersuchungsQuestions')->setEntryType(UntersuchungsQuestionType::class)->setFormTypeOption('by_reference', false),
        ];
    }

    public function run(Request $request, EntityManagerInterface $entityManager)
    {
        $entityId = $request->query->get('entityId');
        $untersuchungsCategory = $entityManager->getRepository(UntersuchungsCategory::class)->find($entityId);
        return $this->render('@ProlyfixGoaBundle/untersuchungsCategory/run.html.twig', [
            'untersuchungsCategory' => $untersuchungsCategory,
        ]);
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::new('run', 'Run')
                ->linkToCrudAction('run')
                ->setCssClass('btn btn-primary'));
    }
}
