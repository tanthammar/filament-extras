<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Field;

/**
 * Consider using JSONEditor field instead.<br>
 * <br>
 * OBSERVE that this field does not update component state.<br>
 * <br>
 * Example usage: <br>
 * PrettyPrint::make('account')<br>
 * ->ignored()<br>
 * ->hiddenOn('create')<br>
 * ->columnSpan('full'),<br>
 */
class PrettyPrintView extends Field
{
    protected string $view = 'filament-extras::components.pretty-print';
}
