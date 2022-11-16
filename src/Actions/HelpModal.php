<?php
namespace TantHammar\FilamentExtras\Actions;

use Illuminate\Support\Str;
use Filament\Forms\Components\Actions\Action;

/**
 * Pass a view path as $name in make()
 */
class HelpModal extends Action
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalContent(view($this->name));
        $this->name = Str::slug($this->name, '-');
        $this->modalHeading('Info');

        $this->action(static function (): void {});
        $this->modalActions(fn ($action): array => [$action->getModalCancelAction()->label('OK')->color('primary')]);
        $this->color('primary');
        $this->requiresConfirmation(false);
        $this->icon('heroicon-o-question-mark-circle');
        $this->iconButton();
    }

}
