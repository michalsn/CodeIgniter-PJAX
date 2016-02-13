# CodeIgniter PJAX Hook

What is PJAX? It's a jquery plugin. For more informations visit [plugin page](https://github.com/defunkt/jquery-pjax).

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

## Testing

```bash
composer install
./vendor/bin/phpunit
```

## License

The MIT License (MIT).