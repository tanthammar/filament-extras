<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\Facades\Cache;

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
        return CheckboxList::make('teams')->label(__('models.Team.plural'))
            ->disabled(!(user()?->isSupport() || user()?->ownsCurrentTeam())) //before relationship(), see Filament docs
            ->default([userTeamId()])
            ->relationship(
                name: 'teams',
                titleAttribute: 'name',
                modifyQueryUsing: fn($get, $query) => TeamBelongsTo::teamQuery($get, $query)
            )
            ->bulkToggleable()
            ->columns(2)
            ->required()
            ->rule('array')
            ->ruleEach('exists:teams,id')
            ->ruleEachInOptions();
    }
}
