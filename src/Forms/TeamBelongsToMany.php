<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
            ->disabled(function(string $operation, Model $record) {
                if(userIsSupport()) return false;
                if($operation === 'create') return !user()->ownsCurrentTeam();
                if($operation === 'edit') return !(user()->ownsCurrentTeam() && $record->team_id === userTeamId());

            }) //must come before relationship(), see Filament docs,
            ->validatedWhenNotDehydrated(false)
            ->default([userTeamId()])//set to current team because the field is disabled for non-team owners
            ->relationship(
                name: 'teams',
                titleAttribute: 'name',
                modifyQueryUsing: fn(Get $get, Builder $query) => TeamBelongsTo::ownedTeams($get, $query, true)
            )
            ->bulkToggleable()
            ->columns(2)
//            ->required() //do not make required, the organizer has a team_id, it does not have to belong to multiple teams
            ->rule('array')
            ->ruleEach('exists:teams,id')
            ->ruleEachInOptions();
    }
}
