<?php

namespace TantHammar\FilamentExtras\Tables;

use Filament\Tables\Columns\Column;

/** Display a countable state as a badge */
class ArrayCount extends Column
{
    protected string $view = 'filament-extras::array-count';
}
