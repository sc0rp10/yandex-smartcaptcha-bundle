# yandex-smartcaptcha-bundle
[Yandex Smart Captcha](https://cloud.yandex.ru/services/smartcaptcha) Symfony 6.1+ integration

## Installation

#### Install library via [composer](https://getcomposer.org/):

```shell
composer require sc0/yandex-smartcaptcha-bundle
```

#### Add it to bundles list:

```php
# bundles.php
<?php

return [
    // ...
    Sc\YandexSmartCaptchaBundle\YandexSmartCaptchaBundle::class => ['all' => true],
    // ...
];

```

#### Configure keys:

```yaml
# config.yaml
yandex_smart_captcha:
    secret_key: foo
    site_key: bar
```

#### Use new Type in forms

```php
use Sc\YandexSmartCaptchaBundle\Form\Type\YandexSmartCaptchaType;
// ...
$builder->add('captcha', YandexSmartCaptchaType::class);
// ...
```

#### Use custom HTML wrapper around the captcha:
```php
# YourType.php
$builder->add('captcha', YandexSmartCaptchaType::class, [
    'block_prefix' => 'my_own_captcha_wrapper',
]);
```

```twig
{% block my_own_captcha_wrapper_widget %}
    <div class="my-captcha-container">
        {{ block('yandex_smartcaptcha_widget') }}
    </div>
{% endblock my_own_captcha_wrapper_widget %}
```