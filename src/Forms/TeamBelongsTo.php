<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;

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
        return Select::make('team_id')->label(__('fields.team'))
            ->relationship('team', 'name')
            ->default(user()->current_team_id)
            ->options(fn ($get) => user()->isSupport()
                ? User::find($get('user_id'))?->allTeams()->pluck('name', 'id') ?? collect()
                : user()->ownedTeams()->pluck('name', 'id') ?? collect()
            )
            ->disablePlaceholderSelection()
            ->rule('array')
            ->ruleInOptions()
            ->required();
    }
}
