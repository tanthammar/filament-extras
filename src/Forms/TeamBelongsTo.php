<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Cache;

class TeamBelongsTo
{
    /**
     * Support can search among ALL teams a user belongs to<br>
     * whereas user only can select between OWNED teams
     *
     * @return CheckboxList
     */
    public static function make(): Select
    {
        $modifyQueryUsing = fn($get, $query) => self::teamQuery($get, $query);

        return Select::make('team_id')->label(__('fields.team'))
            ->disabled(!(user()?->isSupport() || user()?->ownsCurrentTeam())) //before relationship(), see Filament docs
            ->relationship(
                name: 'team',
                titleAttribute: 'name',
                modifyQueryUsing: $modifyQueryUsing
            )
            ->default(userTeamId()) //non-team owners can only select their current team
            ->default(fn (Select $component): ?int => Relation::noConstraints(static fn () => $component->getRelationship())
                ->tap($modifyQueryUsing)
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
