<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;

class VisibilitySection
{
    public static function make(): Section
    {
        return Section::make(__('fields.visibility'))
            //->description('Visibility')
            ->schema([
                //Toggle has rule 'boolean' by default
                Toggle::make('published')->label(__('fields.published'))->helperText(__('fields.published_hint'))->default(true),
                Toggle::make('hide_in_guide')->label(__('fields.hide_in_guide'))->helperText(__('fields.hide_in_guide_hint'))->default(false),
                Toggle::make('hide_contact')->label(__('fields.hide_contact'))->helperText(__('fields.hide_contact_hint'))->default(false),
                Toggle::make('show_on_map')->label(__('fields.show_on_map'))->helperText(__('fields.show_on_map_hint'))->default(true),
            ])->columns(2)->collapsible();

    }

}
