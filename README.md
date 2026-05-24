# Google

fiCMS dependency plugin for Google OAuth provider metadata and reusable Google API helpers.

## OAuth

The plugin exposes `provider/google.json` for `system/plugins/oauth`.

The OAuth client credentials stay in:

```text
system/plugins/oauth/clients/google.json
```

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
