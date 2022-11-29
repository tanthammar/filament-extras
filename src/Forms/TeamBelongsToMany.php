<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\Team;
use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TeamBelongsToMany
{
    public static function make(): Select|CheckboxList
    {
        $user_id = fn($get) => $get('user_id');
        return user()->isSupport()

            ? CheckboxList::make('teams')->label(__('fields.team'))
                ->relationship('teams', 'name')
                ->default([user()->current_team_id])
                ->options($allowedTeams = User::find($user_id)?->allTeams()->pluck('name', 'id') ?? collect())
                ->required()
                ->rules(['array'])
                ->rulesForeachItem(['bail', Rule::in($allowedTeams->keys()->toArray())])

            : CheckboxList::make('teams')->label(__('fields.team'))
                ->relationship('teams', 'name')
                ->default([user()->current_team_id])
                ->options($allowedTeams = user()->ownedTeams()->pluck('name', 'id'))
                ->required()
                ->rules(['array'])
                ->rulesForeachItem(['bail', Rule::in($allowedTeams->keys()->toArray())])
                ->visible(user()->ownedTeams()->count());
    }
}
