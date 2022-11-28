<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Models\Team;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;

class TeamBelongsToMany
{
    public static function make(): Select|CheckboxList
    {
        return user()->isSupport()
            ? Select::make('teams')->label(__('fields.team'))
                ->multiple()
                ->relationship('teams', 'name')
                ->searchable()
                ->getSearchResultsUsing(fn(string $search) => Team::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                ->getOptionLabelUsing(fn($value): ?string => Team::find($value)?->name)
                ->default([user()->current_team_id])
                ->disablePlaceholderSelection()
                ->rule('array')
                ->rulesForeachItem('exists:teams,id')
            : CheckboxList::make('teams')->label(__('fields.team'))
                ->relationship('teams', 'name')
                ->default([user()->current_team_id])
                ->options($allowedTeams = user()->ownedTeams()->pluck('name', 'id'))
                ->rule('array')
                ->rulesForeachItem([Rule::in($allowedTeams->keys()->toArray())])
                ->visible(user()->ownedTeams()->count());
    }
}
