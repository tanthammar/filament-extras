<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Closure;

class JetstreamAuthorSection
{
    public static function make(bool $teamLive = false): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([

                self::author('team'),

                TeamBelongsTo::make()->isReactive($teamLive),

            ])->columns(2)
            ->collapsible()
            ->collapsed()
            ->visible(user()?->isSupport());
    }

    public static function manyTeams(bool $teamLive = false, ?Closure $onUpdatedTeams = null): Section
    {
        return Section::make(__('fields.authors'))
            ->schema([

                self::author('teams')
                    ->disabled(! user()?->isSupport()),

                TeamBelongsToMany::make()
                    ->isReactive($teamLive)
                    ->onUpdated($onUpdated),
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
            ->onUpdated(fn ($set, $state) => $set($field, [
                $state ? User::find($state)?->current_team_id : null,
            ]));
    }
}
