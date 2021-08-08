<?php

declare(strict_types=1);

namespace App\Modules\DefaultModule;

use Fykosak\Utils\UI\PageTitle;

class AboutTheCompetitionPresenter extends BasePresenter
{

    public function renderDefault(): void
    {
        $this->setPageTitle(new PageTitle(_('aboutTheCompetition.title')));
    }
}
