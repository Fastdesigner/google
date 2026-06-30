# Google

fiCMS dependency plugin for Google OAuth provider metadata and reusable Google API helpers.

## OAuth

The plugin exposes OAuth metadata in the same structure as `system/plugins/oauth`:

```text
oauth/provider/google.json
oauth/clients/google.json
```

The system OAuth plugin resolves provider/client defaults from installed plugins. Site-specific OAuth client credentials can override the bundled defaults in:

```text
system/plugins/oauth/clients/google.json
```

The Google provider uses the central fiCMS redirect:

```text
https://fastdesign.de/oauth.php?action=callback
```

Create the Google OAuth app once in the Fastdesigner Google Cloud account and add that exact URL as an authorized redirect URI. Customer installations start OAuth from their own domain, receive the token handoff once, and store the connected account locally under `system/plugins/oauth/accounts/google/<account-ref>.json`.

Connected accounts stay in:

```text
system/plugins/oauth/accounts/google/<account-ref>.json
```

## Business Profile

```php
$google = new \google\BusinessProfile('default');
$accounts = $google->accounts();
$locations = $google->locations('accounts/123');
$reviews = $google->reviews('accounts/123','locations/456');
```

The class uses the official Google Business Profile APIs:
- Account Management API for accounts.
- Business Information API for locations.
- Google My Business API v4 for reviews.

If OAuth cannot provide a usable request, the Google helper forwards `OAuth::last_error()` through `Google::last()['error']` instead of hiding it behind a generic unavailable state.

## Scopes

```php
$scopes = \google\Scopes::searchConsole();
```

Consumers request feature-specific scopes themselves through the shared OAuth flow. The Google dependency plugin does not add Search Console to the provider defaults.

## Search Console

```php
$console = new \google\SearchConsole('default');
$rows = $console->queryPages('sc-domain:example.com','Hotel Sylt','2026-03-24','2026-06-21');
```

Search Console access requires `https://www.googleapis.com/auth/webmasters.readonly` and Search Console property permission for the connected Google account.
