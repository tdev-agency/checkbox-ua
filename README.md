# Checkbox.ua PHP SDK

PHP SDK for [Checkbox.ua](https://checkbox.ua/)

## Installation

The recommended way to install Guzzle is through [Composer](https://getcomposer.org/).

```bash
composer require tdev-agency/checkbox-ua
```

## Usage

### Create SignIn entity:

1. SignIn with login and password:

```php
$entity = \TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity::create([
            'login' => 'login',
            'password' => 'password',
            'license_key' => 'license_key'
]);
```

2. SignIn with pin code:

```php
$entity = \TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity::create([
            'pin_code' => 'pin_code',
            'license_key' => 'license_key'
]);
```

### Initialize checkbox.ua instance

```php
// For pin code sign in
$client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN_PIN_CODE, $entity);
// For sign in with login and password
$client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity);
```

## Tags of api endpoints

Tags based on the official documentation of the checkbox.ua

There are two ways to call required tag.

E.g.: ```$cashier = $client->getCashier();``` or by using helper method
``$cashier = $client->make(\TDevAgency\CheckboxUa\Tags\Cashier::class);``

## Cashier

### Completion of the session of a cashier with the current access token

 ```php
 $client->getCashier()->signOut()
 ```

### Getting information about the current user (cashier)

```php
$client->getCashier()->me()
```

### Receiving information about an active change of user (cashier)

```php 
$client->getCashier()->shift()
```

### Check signature

```php
$client->getCashier()->checkSignature()
```

## Organization

### Get current organization receipt settings

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Organization::class)->receiptConfig()
```

### Get current organization logo

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Organization::class)->logoPng()
```

### Get current organization logo

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Organization::class)->textLogoPng()
```

## Shifts

### Creating a Z-Report and closing the current shift by the user (cashier)

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Shifts::class)->closeShift()
```

Optionally, a Z-Report can be generated on the client side and passed in the body of this request

```php
$entity = \TDevAgency\CheckboxUa\Entities\Requests\ShiftCloseRequestEntity::create($data)
$client->make(\TDevAgency\CheckboxUa\Tags\Shifts::class)->closeShift($entity)
```

``$data`` values:

| Param                    | Default | type                                                           | Description                                                |
|--------------------------|---------|----------------------------------------------------------------|------------------------------------------------------------|
| `skip_client_name_check` | `false` | `boolean`                                                      | Skip Client Name Check                                     |
| `fiscal_code`            | `null`  | `string`                                                       | Offline fiscal number                                      |
| `fiscal_date`            | `null`  | `string`                                                       | Offline fiscal number                                      |
| `report`                 | `null`  | `\TDevAgency\CheckboxUa\Entities\Requests\ReportRequestEntity` | Offline shift close time (ignored when online shift close) |

### Opening a new shift by a cashier

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Shifts::class)->createShift($id, $fiscal_code, $fiscal_date)
```

| Param         | Default | type     | Description                                  |
|---------------|---------|----------|----------------------------------------------|
| `id`          | `null`  | `string` | The shift id is generated on the client side |
| `fiscal_code` | `null`  | `string` | Offline fiscal number                        |
| `fiscal_date` | `null`  | `string` | Offline fiscal number                        |

### Getting current cashier shifts

```php
$client->make(\TDevAgency\CheckboxUa\Tags\Shifts::class)->getShifts($statuses, $limit, $offset, $desc)
```

| Param      | Default | type       | Description                                                                                          |
|------------|---------|------------|------------------------------------------------------------------------------------------------------|
| `statuses` | `[]`    | `array`    | Array of any (Shift Status) Items Enum: "CREATED" "OPENING" "OPENED" "CLOSING" "CLOSED" Shift status |
| `limit`    | `25`    | `int`      | Limit                                                                                                |
| `offset`   | `0`     | `int`      | Offset                                                                                               |
| `desc`     | `false` | `boolean`  | Reverse sort order                                                                                   |

### Receiving information about the current shift
```php 
$client->make(\TDevAgency\CheckboxUa\Tags\Shifts::class)->getShift($id, $options)
```

| Param      | Default | type       | Description        |
|------------|---------|------------|--------------------|
| `id`       |         | `int`      | Required. Shift ID |
