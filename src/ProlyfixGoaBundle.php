<?php

namespace Prolyfix\GoaBundle;

use App\Entity\Module\ModuleConfiguration;
use App\Entity\Module\ModuleRight;
use Prolyfix\GoaBundle\Entity\Number;
use App\Module\ModuleBundle;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Security\AuthorizationChecker;
use Prolyfix\CrmBundle\Entity\Appointment;
use Prolyfix\CrmBundle\Entity\Contact;
use Prolyfix\CrmBundle\Entity\ThirdParty;
use Prolyfix\GoaBundle\Entity\Sequence;
use Prolyfix\GoaBundle\Entity\UntersuchungsCategory;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class ProlyfixGoaBundle extends ModuleBundle
{
    private $authorizationChecker;

    public function setAuthorizationChecker(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public static function getTables(): array
    {
        return [
            Sequence::class,
            UntersuchungsCategory::class,
            Number::class,
        ];
    }

    const IS_MODULE = true;
    public static function getShortName(): string
    {
        return 'GoaBundle';
    }
    public static function getModuleName(): string
    {
        return 'Goa';
    }
    public static function getModuleDescription(): string
    {
        return 'Goa Module';
    }
    public static function getModuleType(): string
    {
        return 'module';
    }
    public static function getModuleConfiguration(): array
    {
        return [];
    }

    public static function getModuleRights(): array
    {
        return [
        ];
    }

    public function getMenuConfiguration(): array
    {
        return ['configuration' => [
            
            MenuItem::linkToCrud('Goa List', 'fas fa-list', Number::class),
        ],
            'Goa' => [
            MenuItem::section('Goa', 'fas fa-hospital'),
            MenuItem::linkToCrud('Goa List', 'fas fa-list', Number::class),
            MenuItem::linkToCrud('Sequences', 'fas fa-list', Sequence::class),
            MenuItem::linkToCrud('SequenceComparison', 'fas fa-list', Sequence::class)->setAction('compareSequences'),
            MenuItem::linkToCrud('iGel', 'fas fa-list', Sequence::class)->setAction('iGelPrice'),
            MenuItem::linkToCrud('frageBogen', 'fas fa-list', UntersuchungsCategory::class)
            ]
        ];
    }

    public static function getUserConfiguration(): array
    {
        return [];
    }

    public static function getModuleAccess(): array
    {
        return [];
    }


}