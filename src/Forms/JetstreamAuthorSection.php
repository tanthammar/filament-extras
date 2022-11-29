<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;

class JetstreamAuthorSection
{
    public static function make(): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([
                Author::make()
                    ->lazy()
                    ->onUpdated(fn($set, $state) => $set('team', [
                        $state ? User::find($state)?->current_team_id : null
                    ])),
                TeamBelongsTo::make()
            ])->columns(2)
            ->collapsible();
    }
}
