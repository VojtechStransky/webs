<?php

declare(strict_types=1);

namespace App\Modules\DefaultModule;

class SchedulePresenter extends BasePresenter
{

    public function renderDefault(): void
    {
        $this->setPageTitle(_('Schedule of the Competition'));
    }
}
