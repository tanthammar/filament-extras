<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;

class TeamBelongsToMany
{
    /**
     * Support can search among ALL teams a user belongs to<br>
     * whereas user only can select between OWNED teams
     *
     * @return CheckboxList
     */
    public static function make(): CheckboxList
    {
        return CheckboxList::make('teams')->label(__('fields.team'))
            ->relationship('teams', 'name')
            ->default([user()->current_team_id])
            ->options(fn ($get) => user()?->isSupport()
                ? User::find($get('user_id'))?->allTeams()->pluck('name', 'id') ?? collect()
                : user()?->ownedTeams()->pluck('name', 'id') ?? collect()
            )
            ->bulkToggleable()
            ->columns(2)
            ->required()
            ->rule('array')
            ->ruleEachInOptions()
            ->visible(user()?->isSupport() || user()?->hasOwnedTeams());
    }
}
