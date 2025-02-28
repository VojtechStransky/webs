<?php

declare(strict_types=1);

namespace App\Modules\Fol\DefaultModule;

use App\Components\Countdown\CountdownComponent;
use App\Components\ResultsPanel\ResultsPanelComponent;
use App\Components\UpperHomeBeforeRegistration\UpperHomeBeforeRegistrationComponent;
use App\Components\UpperHomeMap\UpperHomeMapComponent;

class DefaultPresenter extends BasePresenter
{
    protected function createComponentUpperHomeMap(): UpperHomeMapComponent
    {
        return new UpperHomeMapComponent($this->getContext(), $this->gamePhaseCalculator);
    }

    protected function createComponentUpperHomeBeforeRegistration(): UpperHomeBeforeRegistrationComponent
    {
        return new UpperHomeBeforeRegistrationComponent($this->gamePhaseCalculator);
    }

    protected function createComponentCountdown(): CountdownComponent
    {
        return new CountdownComponent($this->gamePhaseCalculator->getGameBegin());
    }

    protected function createComponentResultsPanel(): ResultsPanelComponent
    {
        return new ResultsPanelComponent($this->getContext());
    }
}
