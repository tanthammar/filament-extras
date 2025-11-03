<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\Team;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class TeamBelongsTo
{
    /**
     * Support can search among ALL teams a user belongs to<br>
     * whereas user only can select between OWNED teams
     */
    public static function make(): Select
    {
        // The user must own the current team, to be allowed to move items to another team
        // the user must also own the team they try to move items to.
        // The ownedTeams query returns current team and owned teams
        // The field is disabled if the user doesn't own the current team

        return Select::make('team_id')->label(__('fields.team'))
            ->disabled(function(string $operation, ?Model $record) {
                if(userIsSuperAdmin()) return false;
                if($operation === 'create') return !user()->ownsCurrentTeam();
                if($operation === 'edit') return !(user()->ownsCurrentTeam() && $record?->team_id === userTeamId());


            }) //must come before relationship(), see Filament docs,
            ->validatedWhenNotDehydrated(false)
            ->default(userTeamId()) //set to current team because the field is disabled for non-team owners
            ->relationship(
                name: 'team',
                titleAttribute: 'name',
                modifyQueryUsing: fn(Builder $query, \Filament\Schemas\Components\Utilities\Get $get) => self::ownedTeams($get, $query)
            )
            ->exists('teams', 'id')
            ->ruleInOptions()
            ->required();
    }


    /** OBSERVE used by TeamBelongsToMany */
    public static function ownedTeams(Get $get, Builder $query, bool $belongsToMany = false): Builder
    {
        //Support can move items to any team the selected user is related to, no matter if it's owned or not
        if(user()->isSupport() && $userId = $get('user_id')) {
            return $query->where('user_id', $userId)->orWhereRelation('users', 'user_id', $userId);
        }

        //users can only select between their current team or owned teams
        //but if they don't own any team the current team is selected by default, and the field is disabled
        return  $query->where(($belongsToMany ? 'team_id' : 'id'), userTeamId())
            ->orWhere('user_id', user()->id);
    }
}
