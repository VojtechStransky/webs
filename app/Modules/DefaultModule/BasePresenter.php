<?php

declare(strict_types=1);

namespace App\Modules\DefaultModule;

use App\Components\Navigation\NavItem;
use Fykosak\Utils\UI\PageTitle;

abstract class BasePresenter extends \App\Modules\Core\BasePresenter
{

    protected function getNavItems(): array
    {
        $items = [];

        $items[] = new NavItem(
            new PageTitle(_('O soutěži'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:AboutTheCompetition:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Archiv'), 'visible-sm-inline glyphicon glyphicon-compressed'), // TODO
            ':Default:Archive:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Organizátoři'), 'visible-sm-inline glyphicon glyphicon-compressed'), // TODO
            ':Default:Organisers:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Pravidla'), 'visible-sm-inline glyphicon glyphicon-exclamation-sign'), // TODO
            ':Default:Rules:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('FAQ'), 'visible-sm-inline glyphicon glyphicon-question-sign'), // TODO
            ':Default:Faq:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Návod'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:HowToPlay:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Program'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:Schedule:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('Reporty'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:Reports:default',
        );

        //if ($this->yearsService->isRegistrationStarted()) {
        //$items[] = new NavItem(':Default:Team:list', [], _('Týmy'), 'visible-sm-inline glyphicon glyphicon-list');
        //  if ($this->yearsService->isGameStarted()) {
        // $items[] = new NavItem(':Archive:Archive:results', [],
        // _('Výsledky'), 'visible-sm-inline glyphicon glyphicon-stats');
        // }
        //}

        // if ($this->yearsService->isRegistrationActive()) {
        //    if (!$this->getUser()->isLoggedIn()) {
        $items[] = new NavItem(
            new PageTitle(_('Registrace'), 'visible-sm-inline glyphicon glyphicon-edit'), // TODO
            ':Default:Default:default',
        );
        //    }
        // }
        return $items;
    }
}
