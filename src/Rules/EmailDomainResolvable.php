<?php

namespace TantHammar\FilamentExtras\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Verifies that an email address' domain can receive mail.
 *
 * Unlike Laravel's `email:dns` rule, this fails *open* on transient DNS
 * failures (SERVFAIL / timeout, where dns_get_record() returns false). It only
 * fails *closed* when the domain definitively resolves with no mail-capable
 * records, which catches genuine typos like "gmial.com" without rejecting
 * legitimate addresses whose nameservers are briefly unreachable.
 */
class EmailDomainResolvable implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! str_contains($value, '@')) {
            return; // Format is handled by the `email` rule.
        }

        $domain = substr(strrchr($value, '@'), 1);

        if ($domain === '') {
            return;
        }

        $mx = @dns_get_record($domain, DNS_MX);

        // false = transient lookup failure → fail open. Non-empty = has MX.
        if ($mx === false || count($mx) > 0) {
            return;
        }

        // No MX records: a domain may still accept mail at its A/AAAA host.
        $address = @dns_get_record($domain, DNS_A + DNS_AAAA);

        if ($address === false || count($address) > 0) {
            return;
        }

        $fail('validation.email')->translate();
    }
}
