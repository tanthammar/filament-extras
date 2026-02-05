<?php

namespace TantHammar\FilamentExtras\Enums;

enum PlaceholderMethod: string
{
    case POLITE = 'polite'; //applies placeholder if input doesn't have one defined
    case AGGRESSIVE = 'aggressive'; //replaces any existing placeholder
    case OFF = 'off';
}
