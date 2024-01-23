<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class TeamBelongsTo
{
    /**
     * Support can search among ALL teams a user belongs to<br>
     * whereas user only can select between OWNED teams
     */
    public static function make(): Select
    {
        return Select::make('team_id')->label(__('fields.team'))
            ->disabled(!(user()?->isSupport() || user()?->ownsCurrentTeam())) //before relationship(), see Filament docs
            ->relationship(
                name: 'team',
                titleAttribute: 'name',
                modifyQueryUsing: fn(Builder $query, \Filament\Forms\Get $get) => self::teamQuery($get, $query)
            )
            ->default(userTeamId()) //non-team owners can only select their current team
            ->default(fn (Select $component, Get $get): ?int => Relation::noConstraints(static fn () => $component->getRelationship())
                ->tap(fn ($query, $get) => self::teamQuery($get, $query))
                ->first() //default value is the first item returned from the query
                ?->getKey())
            ->exists('teams', 'id')
            ->ruleInOptions()
            ->required();
    }

    /**
     * All teams selected user belongs to
     */
    public static function teamQuery($get, $query): Builder
    {
        $userId = user()?->isSupport() ? $get('user_id') : user()->id;

        return $query->whereRelation('users', 'user_id', $userId)->orWhere('user_id', $userId);
    }
}
