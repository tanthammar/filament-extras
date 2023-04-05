<?php

namespace TantHammar\FilamentExtras\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Search the Open Street Map database using Nominatim
 * https://nominatim.org/release-docs/latest/
 */
class Nominatim
{
    /**
     * https://nominatim.org/release-docs/latest/api/Search/
     */
    public static function search(string $address): array
    {
        $empty = ['empty' => trans('filament-extras::misc.no-addresses-found')];

        if (blank($address)) {
            return $empty;
        }

        sleep(1); //Nominatim api has a rate limit of 1 second

        $response = Http::retry(2, 1000)->get("https://nominatim.openstreetmap.org/search?addressdetails=1&q=$address&format=json");

        return $response->ok() ? self::format(collect($response->json()), $empty) : $empty;
    }

    protected static function format(Collection $collection, array $empty): array
    {
        return $collection
            ->pluck('display_name', 'osm_id')
            ->whenNotEmpty(
                fn ($collection) => $collection->toArray(),
                fn () => $empty
            );
    }

    /**
     * https://nominatim.org/release-docs/latest/api/Lookup/
     */
    public static function lookup(?int $osm_id, ?array $existingFieldValue = []): array
    {
        if (! $osm_id) {
            return [];
        }

        sleep(1); //Nominatim api has a rate limit of 1 second

        $response = Http::retry(2, 1000)->get("https://nominatim.openstreetmap.org/lookup?addressdetails=1&osm_ids=W$osm_id,R$osm_id,N$osm_id&limit=1&format=json");

        if ($response->ok()) {
            $c = collect($response->json())->first();
            data_set($c, 'address.lat', data_get($c, 'lat', null));
            data_set($c, 'address.lon', data_get($c, 'lon', null));
            data_set($c, 'address.country_code', strtoupper(data_get($c, 'address.country_code', '')));
            $address = data_get($c, 'address', []);
            $mapped = [];
            $mapped['street'] = rtrim(data_get($address, 'road') . ' ' . data_get($address, 'house_number'));
            $mapped['zip'] = data_get($address, 'postcode');
            $mapped['city'] = self::getCity($address);
            $mapped['state'] = data_get($address, 'state') ?? data_get($address, 'municipality');
            $mapped['county'] = data_get($address, 'county');
            $mapped['country'] = data_get($address, 'country');
            $mapped['country_code'] = data_get($address, 'country_code');
            $mapped['latitude'] = data_get($address, 'lat');
            $mapped['longitude'] = data_get($address, 'lon');

            return array_merge($existingFieldValue ?? [], $mapped);
        }

        return [];
    }

    protected static function getCity($address): ?string
    {
        $city = data_get($address, 'city') ?? data_get($address, 'village');
        //fix for OSM Swedish city/state mixup
        if (str_ends_with($city, 's kommun')) {
            return str_replace('s kommun', '', $city);
        }

        return $city;
    }

    /**
     * Get first found lat/lon from an address string<br>
     * returns array with format [string|float|null $lat, string|float|null $lon],
     */
    public static function getFirstLatLong(string $address): array
    {
        $noResult = [null, null];

        if ($address = '') {
            return $noResult;
        }
        sleep(1); //Nominatim api rate limit

        $response = Http::retry(2, 1000)->get("https://nominatim.openstreetmap.org/search?addressdetails=1&q=$address&format=json");

        if ($response->ok()) {
            $c = collect(collect($response->json())->first());

            return [$c->get('lat'), $c->get('lon')];
        }

        return $noResult;
    }
}
