<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;

class JetstreamAuthorSection
{
    public static function make(): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([

                self::author('team_id') //swapping author swaps model->team_id
                ->disabled(! user()?->isSupport()),

                TeamBelongsTo::make(),

            ])->columnSpanFull()
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

                self::author('team_id') //swapping author swaps model->team_id
                ->disabled(! user()?->isSupport()),

                TeamBelongsToMany::make(),
            ])
            ->columnSpanFull()
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
