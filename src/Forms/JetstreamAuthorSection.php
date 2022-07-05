<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class JetstreamAuthorSection
{
    public static function make(): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([
                Select::make('user_id')->label(__('fields.user'))
                    ->relationship('author', 'name')
                    ->default(\Auth::id()),
                Select::make('team_id')->label(__('fields.team'))
                    ->relationship('ownedByTeam', 'name')
                    ->default(user()->current_team_id),
            ])->columns(2)
            ->collapsible();
    }
}
