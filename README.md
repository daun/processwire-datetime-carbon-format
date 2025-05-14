# ProcessWire Datetime Carbon Format

[![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/daun/processwire-datetime-carbon-format?color=97aab4&label=version)](https://github.com/daun/processwire-datetime-carbon-format/releases)
[![GitHub License](https://img.shields.io/github/license/daun/processwire-datetime-carbon-format?color=97aab4)](./LICENSE)

Format Datetime fields as [Carbon](https://carbon.nesbot.com/) instances.

## Installation

Install the module using Composer. This will install Carbon as a child dependency.

```bash
composer require daun/datetime-carbon-format
```

> ℹ️ Installation via the module directory will only work if you already have `nesbot/carbon` required from the project root.

## Usage

All Datetime fields will now be formatted as Carbon instances instead of strings. Some examples of how to make use of this:

```php
// $page->date is a Datetime field
// Output format: j/n/Y

echo $page->date;                    // 20/10/2027
echo $page->date->add('7 days');     // 27/10/2027
echo $page->date->format('l, F j');  // Monday, October 20
echo $page->date->year;              // 2027
echo $page->date->diffForHumans();   // 28 minutes ago
```

Consult the [Carbon docs](https://carbon.nesbot.com/docs/) for details.

## Notes

### Frontend only

The ProcessWire admin expects datetime fields to be strings. That's why this module will only return Carbon instances on normal frontend page views.

### Date output format

When casting a Carbon instance to a string (usually when outputting the field in a template), the field's date output format will be respected.

### Empty values

Empty date fields will be wrapped in a proxy object that silently "swallows" access to properties and methods without triggering an exception. That's because Carbon instances cannot be empty, i.e. created without a valid timestamp value.

Use either the `timestamp` property or the `isset` accessor to see if a date has a value.

```php
// Date field with data
$page->date->timestamp;    // 1778870000
$page->date->isset;        // true
$page->date->year;         // 2027
$page->date->format('j');  // 20

// Empty date field
$page->date->timestamp;    // null
$page->date->isset;        // null
$page->date->year;         // null
$page->date->format('j');  // null
```

### `carbon` API Variable

The module will create a pre-configured Carbon Factory and wire it into a new `carbon` API variable. This factory object can be used to create new Carbon instances, edit settings on it, etc.

```php
// Create a new Carbon instance
$datetime = wire()->carbon->createFromTimestamp($timestamp);
```

## Contributing

Pull requests are welcome. Please read the [Contributing Guidelines](./CONTRIBUTING.md).

## License

[MIT](./LICENSE)
