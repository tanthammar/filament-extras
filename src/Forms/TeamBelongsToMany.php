<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Closure;

class TeamBelongsToMany
{
    /**
     * Visible to support and user who owns the current team.
     *
     * Support can search among ALL teams a user belongs to<br>
     * whereas user only can select between OWNED teams
     */
    public static function make(): CheckboxList
    {
        /**
         * When using disabled() with relationship(),
         * ensure that disabled() is called before relationship().
         * This ensures that the dehydrated() call from within relationship()
         * is not overridden by the call from disabled()
         */
        return CheckboxList::make('teams')->label(__('fields.team'))
            ->disabled( ! (user()?->isSupport() || user()?->ownsCurrentTeam()) ) //before relationship()
            ->default([user()->current_team_id]) //non-team owners can only select their own team
            ->relationship('teams', 'name')
            ->options(
                fn ($get) => user()?->isSupport()
                    ? User::find($get('user_id'))?->allTeams()->pluck('name', 'id') ?? collect() //support can see all user related teams
                    : user()?->ownedTeams()->pluck('name', 'id') ?? collect() //current team owner can only see other owned teams
            )
            ->bulkToggleable()
            ->columns(2)
            ->required()
            ->rule('array')
            ->ruleEachInOptions();
    }
}
