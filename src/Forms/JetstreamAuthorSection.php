<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;

class JetstreamAuthorSection
{
    public static function make(): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([

                self::author('team')
                    ->disabled(! user()?->isSupport()),

                TeamBelongsTo::make(),

            ])->columns(2)
            ->collapsible()
            ->collapsed();
    }

    /**
     * Team belongs to many checklist.
     */
    public static function manyTeams(): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([

                self::author('teams')
                    ->disabled(! user()?->isSupport()),

                TeamBelongsToMany::make(),
            ])
            ->columns(2)
            ->collapsible()
            ->collapsed();
    }

    protected static function author(string $updatesField): Select
    {
        return Author::make()
            ->lazy()
            ->required()
            ->onUpdated(fn ($set, $state) => $set($updatesField, [
                $state ? User::find($state)?->current_team_id : null,
            ]));
    }
}
