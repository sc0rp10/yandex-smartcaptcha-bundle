<?php declare(strict_types=1);

namespace Sc\YandexSmartCaptchaBundle\Validator\Constraints;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class YandexSmartCaptchaValidator extends ConstraintValidator
{
    private const VALIDATE_URL = 'https://captcha-api.yandex.ru/validate';

    private const SUCCESS_MESSAGE = 'ok';

    public function __construct(
        private readonly RequestStack $request_stack,
        private readonly string $captcha_private_key
    ) {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof YandexSmartCaptcha) {
            throw new UnexpectedTypeException($constraint, YandexSmartCaptcha::class);
        }

        $request = $this->request_stack->getMainRequest();
        $token = $request?->request->get('smart-token');

        if (!$token) {
            $this->context->buildViolation($constraint->empty_message)->addViolation();

            return;
        }

        $query = http_build_query([
            'secret' => $this->captcha_private_key,
            'token' => $token,
            'ip' => $request?->getClientIp(),
        ]);

        $context = stream_context_create([
            'http' => [
                'ignore_errors' => true,
                'timeout' => 5,
            ],
        ]);

        $result = file_get_contents(self::VALIDATE_URL.'?'.$query, false, $context);

        if ($result === '') {
            // invalid status code or other transport exception
            $this->context->buildViolation($constraint->invalid_message)->addViolation();

            return;
        }

        $data = json_decode($result, true, 5, JSON_THROW_ON_ERROR);

        if ($data['status'] !== self::SUCCESS_MESSAGE) {
            // invalid response
            $this->context->buildViolation($constraint->invalid_message)->addViolation();
        }
    }
}
