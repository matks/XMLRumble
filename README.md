XMLRumble
=========

This buddy will find all XLIFF translation files in your Symfony2 project and convert them into YAML.

## Installation

Install the dependencies with composer
```bash
composer install
```

## Tests

Install the dev dependencies with composer
```bash
composer install --dev
```

Run the unit tests suite with atoum binary.
```bash
vendor/bin/atoum -bf vendor/autoload.php -d tests/Units/
```

Run the functional tests.
```bash
rumble-functional-test
```

## Running Rumble

Run the following command:
```bash
$ php rumble <target directory>
```