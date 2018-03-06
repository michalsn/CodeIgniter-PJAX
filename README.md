# CodeIgniter PJAX
[![Build Status](https://travis-ci.org/michalsn/CodeIgniter-PJAX.svg?branch=master)](https://travis-ci.org/michalsn/CodeIgniter-PJAX)

What is PJAX? It's a jquery plugin. For more information visit the [plugin page](https://github.com/defunkt/jquery-pjax).
This hook enable the use of PJAX in CodeIgniter.

## Installation

Copy `application/core/MY_Input.php` and `application/hooks/Pjax.php` to your project.

Add below code to `application/config/hooks.php` file
```php
$hook['post_controller'][] = array(
        'class'    => 'Pjax',
        'function' => 'initialize',
        'filename' => 'Pjax.php',
        'filepath' => 'hooks'
);
```

Enable hooks in your `application/config/config.php` file, by setting `$config['enable_hooks']` variable to `TRUE`.

## Limitations

PJAX container must be an `id` attribute.

## Example

Working example can be found [here](https://github.com/michalsn/CodeIgniter-PJAX-example).

## Testing

```bash
composer install
./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
