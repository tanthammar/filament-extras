# Very opinionated Filament extras
In this repository I will add helpers, blade components, fields and columns that I use in my Filament projects.
Regard them as a templates for your own apps...

If they get merged into the main Filament repo, they will be removed here!, but then you'll find them there ;)

Might be best to fork this repo so you're in control of changes, or install the dev branch. It is not my plan to keep release versions.

## Documentation
There won't be much documentation written, this repository will grow as I add items.
Hopefully the source code contains enough hints to use the components.
If not, please post a question in the discussions tab.

## Requirements
- PHP 8.0|8.1+
- Laravel v9.0+
- Livewire v2.0+
- Filament v2.0+

## Installation
```bash
composer require tanthammar/filament-extras
```

## Screenshots
Disabled field

![](images/Disabled.png) ![](images/Disabled-dark.png)

AddressSection

![AddressSection](images/AddressSection.gif)

## Macros
See `FilamentExtrasServiceProvider`

saveIfSelfFilled
saveIfSelfBlank
saveIfSelfValue
saveIfSelfNoValue
saveAs
ignored
requiredIfBlank
requiredIfFilled
requiredIfChecked
requiredIfUnChecked
nullableIfBlank
nullableIfFilled
nullableIfChecked
nullableIfUnChecked
hiddenIfBlank
hiddenIfFilled
hiddenIfChecked
hiddenIfUnChecked
visibleIfBlank
visibleIfFilled
visibleIfChecked
visibleIfUnChecked
ucwords
ucfirst
smallcaps
uppercase

## Blade components
See resources/views/components

Example
```html
<x-filament-extras::form submit="submitMethodName" label="Form heading" description="Very nice form component" button="Save">
    {{ $this->form }}
    <x-slot name="buttons"> <!-- optional slot inlined with the save button --> </x-slot>
</x-filament-extras::form>
```

## Form Fields
See src/Forms


```php
FirstName::make()
LastName::make()
Email::make()
PasswordInput::current()
PasswordInput::create()
PasswordInput::confirmation()
Mobile::make(column: 'mobile') //validates international mobile numbers
LandLine::make(column: 'landline')//validates international landline numbers
Phone::make(column: 'phone') //validates international phone numbers (disregards phone number type)
```

## Table Column examples
See src/Tables
```php
DTOColumn::make(string $column, string $attribute), //If you cast your json column into DTO's. Retrieved as $column?->attribute ?? ''
JsonColumn::make(string $column, string $dotNotation) //Cast your json column into 'array'. Retreived as data_get($column, $dotNotation, '')
PhoneColumn::make(string $column) //Format international phone numbers
```


