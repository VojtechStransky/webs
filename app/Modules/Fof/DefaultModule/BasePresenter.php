<?php

declare(strict_types=1);

namespace App\Modules\Fof\DefaultModule;

use Fykosak\Utils\UI\Navigation\NavItem;
use Fykosak\Utils\UI\PageTitle;

abstract class BasePresenter extends \App\Modules\Fof\Core\BasePresenter
{

    /**
     * @throws \Throwable
     */
    protected function getNavItems(): array
    {
        $items = [];

        $items[] = new NavItem(
            new PageTitle(_('about.menu'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:AboutTheCompetition:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('rules.menu'), 'visible-sm-inline glyphicon glyphicon-exclamation-sign'), // TODO
            ':Default:Rules:default',
        );
        $items[] = new NavItem(
            new PageTitle(_('faq.menu'), 'visible-sm-inline glyphicon glyphicon-question-sign'), // TODO
            ':Default:Faq:default',
        );
//        $items[] = new NavItem(
//            new PageTitle(_('howToPlay.menu'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
//            ':Default:HowToPlay:default',
//        );
        $items[] = new NavItem(
            new PageTitle(_('schedule.menu'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
            ':Default:Schedule:default',
        );
//        $items[] = new NavItem(
//            new PageTitle(_('reports.menu'), 'visible-sm-inline glyphicon glyphicon-info-sign'), // TODO
//            ':Default:Reports:default',
//        );
        $items[] = new NavItem(
            new PageTitle(_('archive.menu'), 'visible-sm-inline glyphicon glyphicon-compressed'), // TODO
            ':Default:Archive:default',
        );

        return $items;
    }
}
