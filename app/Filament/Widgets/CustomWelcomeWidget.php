<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CustomWelcomeWidget extends Widget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.custom-welcome-widget';
}
