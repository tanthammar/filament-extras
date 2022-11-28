<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rule;
use App\Models\Team;

class TeamBelongsTo
{
    public static function make(): Select
    {
        return user()->isSupport()
            ? Select::make('team_id')->label(__('fields.team'))
                ->relationship('team', 'name')
                ->searchable()
                ->default(user()->current_team_id)
                ->getSearchResultsUsing(fn(string $search) => Team::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
                ->getOptionLabelUsing(fn($value): ?string => Team::find($value)?->name)
                ->disablePlaceholderSelection()
                ->rule('array')
                ->rulesForeachItem([Rule::exists('teams', 'id')])

            : Select::make('team_id')->label(__('fields.team'))
                ->disablePlaceholderSelection()
                ->relationship('team', 'name')
                ->options($allowedTeams = user()->ownedTeams()->pluck('name', 'id'))
                ->default(user()->current_team_id)
                ->rules([Rule::in($allowedTeams->keys()->toArray())])
                ->visible(user()->ownedTeams()->count());
    }
}
