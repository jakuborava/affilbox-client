# Affilbox Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jakuborava/affilbox-client.svg?style=flat-square)](https://packagist.org/packages/jakuborava/affilbox-client)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jakuborava/affilbox-client/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jakuborava/affilbox-client/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jakuborava/affilbox-client.svg?style=flat-square)](https://packagist.org/packages/jakuborava/affilbox-client)

A Laravel package providing a fluent API client for the [Affilbox](https://www.affilbox.cz) affiliate marketing platform. Supports PHP 8.3+ and Laravel 11/12.

## Installation

```bash
composer require jakuborava/affilbox-client
```

Publish the config file:

```bash
php artisan vendor:publish --tag="affilbox-client-config"
```

Add your credentials to `.env`:

```env
AFFILBOX_INSTANCE_NUMBER=your-instance-number
AFFILBOX_API_KEY=your-api-key
```

## Usage

You can use the Facade or inject the client via dependency injection:

```php
use JakubOrava\AffilboxClient\Facades\AffilboxClient;

// Facade
$dashboard = AffilboxClient::dashboard()->get();

// Dependency injection
use JakubOrava\AffilboxClient\AffilboxClient;

public function __construct(private AffilboxClient $client) {}

$dashboard = $this->client->dashboard()->get();
```

You can also pass credentials directly:

```php
$client = new AffilboxClient('instance-number', 'api-key');
```

### Test Connection

```php
$client->test()->ping();             // Returns "pong"
$client->test()->checkCredentials(); // Returns "ok"
```

### Dashboard

```php
$dashboard = $client->dashboard()->get(); // DashboardDTO

$dashboard->clicks;
$dashboard->conversions;
$dashboard->commission;
$dashboard->pending;
$dashboard->payment;
$dashboard->total;
```

### Instance

```php
$instance = $client->instance()->get(); // InstanceDTO

$instance->domain;
$instance->currency;
$instance->locked;
$instance->terminated;
$instance->expire; // Carbon|false
```

### Campaigns

```php
$campaigns = $client->campaigns()->list(); // Collection<int, CampaignDTO>

foreach ($campaigns as $campaign) {
    $campaign->id;
    $campaign->name;
    $campaign->active;
    $campaign->commission;
}
```

### Conversions

**List conversions:**

```php
use JakubOrava\AffilboxClient\Requests\ConversionsListRequest;
use JakubOrava\AffilboxClient\Enums\ConversionState;
use Carbon\Carbon;

// All conversions
$conversions = $client->conversions()->list();

// Filtered
$request = (new ConversionsListRequest)
    ->state(ConversionState::Authorized)
    ->dateFrom(Carbon::parse('2024-01-01'))
    ->dateTo(Carbon::parse('2024-12-31'))
    ->campaignId(42)
    ->coupon('SUMMER');

$conversions = $client->conversions()->list($request); // Collection<int, ConversionDTO>
```

**Add a conversion:**

```php
use JakubOrava\AffilboxClient\Requests\AddConversionRequest;

$request = new AddConversionRequest(
    campaignId: 42,
    userId: 'partner@example.com',
    createDate: Carbon::now(),
    value: 200.00,
);

// Optional fluent methods
$request->sales(150.00)
    ->transactionId('TXN-123')
    ->channel('web')
    ->coupon('SUMMER');

$client->conversions()->add($request);
```

**Change a conversion:**

```php
use JakubOrava\AffilboxClient\Requests\ChangeConversionRequest;

$request = (new ChangeConversionRequest(
    conversionId: 23,
    state: ConversionState::Authorized,
))
    ->value(123.46)
    ->sales(100.00)
    ->currency('CZK')
    ->comment('Approved');

$client->conversions()->change($request);
```

### Partners

**List partners:**

```php
use JakubOrava\AffilboxClient\Requests\PartnersListRequest;

// All partners
$partners = $client->partners()->list();

// Filtered
$request = (new PartnersListRequest)
    ->registerFrom(Carbon::parse('2024-01-01'))
    ->registerTo(Carbon::parse('2024-12-31'))
    ->lastLoginFrom(Carbon::parse('2024-06-01'));

$partners = $client->partners()->list($request); // Collection<int, PartnerDTO>

foreach ($partners as $partner) {
    $partner->person->name;
    $partner->person->email;
    $partner->company->name;
    $partner->address->city;
}
```

**Add a partner:**

```php
use JakubOrava\AffilboxClient\Requests\AddPartnerRequest;

$request = (new AddPartnerRequest('partner@example.com'))
    ->name('Jan')
    ->surname('Novák')
    ->phone('+420608100100')
    ->street('Národní 12')
    ->city('Praha')
    ->postCode('10000')
    ->country('CZ')
    ->company('Firma s.r.o.')
    ->ic('12345678')
    ->dic('CZ12345678');

$response = $client->partners()->add($request); // AddPartnerResponseDTO

$response->instance;
$response->url;
$response->apiKey;
$response->login;
$response->password;
```

### Invoices

**List invoices:**

```php
$invoices = $client->invoices()->list(); // Collection<int, InvoiceDTO>

foreach ($invoices as $invoice) {
    $invoice->id;
    $invoice->vs;
    $invoice->paid;
    $invoice->issueDate;  // Carbon
    $invoice->dueDate;    // Carbon
    $invoice->supplier;   // SupplierDTO
    $invoice->customer;   // CustomerDTO

    foreach ($invoice->items as $item) {
        $item->item;
        $item->amount;
        $item->currency;
    }
}
```

**Request billing:**

```php
$status = $client->invoices()->billingRequest();
```

**Upload an invoice:**

```php
use JakubOrava\AffilboxClient\Requests\UploadInvoiceRequest;

$request = new UploadInvoiceRequest(
    invoiceId: 24,
    issuedOn: Carbon::parse('2024-10-09'),
    due: Carbon::parse('2024-10-19'),
    vs: 202410045,
    file: base64_encode(file_get_contents('invoice.pdf')),
);

$invoice = $client->invoices()->upload($request); // InvoiceDTO
```

## DTOs

All DTOs use readonly properties. Dates are `Carbon` instances.

| DTO | Key Properties |
|-----|---------------|
| `DashboardDTO` | `clicks`, `conversions`, `commission`, `pending`, `payment`, `total` |
| `InstanceDTO` | `domain`, `currency`, `paymentMinimum`, `licence`, `locked`, `terminated`, `expire` |
| `CampaignDTO` | `id`, `name`, `active`, `commission`, `fixCommission`, `cookieValidity`, `trackingCode`, `conversionCode` |
| `ConversionDTO` | `id`, `createDate`, `confirmDate`, `campaignName`, `value`, `sales`, `state`, `transactionId`, `coupon` |
| `PartnerDTO` | `person` (PersonDTO), `address` (AddressDTO), `company` (CompanyDTO) |
| `InvoiceDTO` | `id`, `created`, `issueDate`, `dueDate`, `supplier`, `customer`, `vs`, `paid`, `items` |
| `AddPartnerResponseDTO` | `instance`, `url`, `apiKey`, `login`, `password` |

## Enums

### ConversionState

| Case | Value |
|------|-------|
| `Waiting` | `waiting` |
| `Rejection` | `rejection` |
| `Authorized` | `authorized` |
| `Invoiced` | `invoiced` |

## Error Handling

All exceptions extend `AffilboxClientException`, so you can catch them individually or as a group:

```php
use JakubOrava\AffilboxClient\Exceptions\AffilboxClientException;
use JakubOrava\AffilboxClient\Exceptions\AuthenticationException;
use JakubOrava\AffilboxClient\Exceptions\ValidationException;
use JakubOrava\AffilboxClient\Exceptions\ApiErrorException;
use JakubOrava\AffilboxClient\Exceptions\UnexpectedResponseException;

try {
    $client->conversions()->list();
} catch (AuthenticationException $e) {
    // 401 - Invalid credentials
} catch (ValidationException $e) {
    // 422 - Validation error
} catch (ApiErrorException $e) {
    // Server error or API error status
} catch (UnexpectedResponseException $e) {
    // Non-array / malformed response
} catch (AffilboxClientException $e) {
    // Catch-all for any client exception
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jakub Orava](https://github.com/jakuborava)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
