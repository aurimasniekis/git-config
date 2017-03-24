# GitConfig Component

[![Latest Version](https://img.shields.io/github/release/Aurimasniekis/git-config.svg?style=flat-square)](https://github.com/aurimasniekis/git-config/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/aurimasniekis/git-config.svg?style=flat-square)](https://travis-ci.org/aurimasniekis/git-config)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/aurimasniekis/git-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/aurimasniekis/git-config)
[![Quality Score](https://img.shields.io/scrutinizer/g/aurimasniekis/git-config.svg?style=flat-square)](https://scrutinizer-ci.com/g/aurimasniekis/git-config)
[![Total Downloads](https://img.shields.io/packagist/dt/aurimasniekis/git-config.svg?style=flat-square)](https://packagist.org/packages/aurimasniekis/git-config)

[![Email](https://img.shields.io/badge/email-team@aurimasniekis.io-blue.svg?style=flat-square)](mailto:team@aurimasniekis.io)

Provides interface for `git config`.


## Install

Via Composer

```bash
$ composer require aurimasniekis/git-config
```

## Usage

Initialization:

```php
// Uses `git` from $PATH and standard `.gitconfig` files
$config = new Config();

// Uses custom `git` path
$config = new Config('/usr/local/bin/git');

// Uses custom `.gitconfig` file
$config = new Config(null, '~/.gitconfig');
```

Get value

```php
$config->get('user.name')
```

Set value

```php
$config->get('user.name', 'Foo Bar')
```

Unset value

```php
$config->unSet('user.name')
```

## Testing

```bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.


## License

Please see [License File](LICENSE) for more information.
