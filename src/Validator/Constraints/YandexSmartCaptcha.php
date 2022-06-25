<?php declare(strict_types=1);

namespace Sc\YandexSmartCaptchaBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class YandexSmartCaptcha extends Constraint
{
    public string $invalid_message = 'Captcha must be chosen';
    public string $empty_message = 'Captcha must be chosen';

    public function validatedBy(): string
    {
        return YandexSmartCaptchaValidator::class;
    }
}
