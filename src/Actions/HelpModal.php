<?php

namespace TantHammar\FilamentExtras\Actions;

use Filament\Forms\Components\Actions\Action;
use Illuminate\Support\Str;

/**
 * Pass a view path as $name in make()
 */
class HelpModal extends Action
{
    protected string $modalContentView = '';

    public function getModalContentView()
    {
        return $this->modalContentView;
    }

    public static function makeView(
        string $key,
        string $view,
        string $heading = 'Info',
        string $iconColor = 'primary',
        string $icon = 'heroicon-o-question-mark-circle',
    ): static
    {
        return static::make($key)
            ->modalContent(view($view))
            ->modalHeading($heading)
            ->modalFooterActions(fn($action): array => [$action->getModalCancelAction()->label('OK')->color('primary')])
            ->color($iconColor)
            ->requiresConfirmation(false)
            ->icon($icon)
            ->iconButton();
    }
}
