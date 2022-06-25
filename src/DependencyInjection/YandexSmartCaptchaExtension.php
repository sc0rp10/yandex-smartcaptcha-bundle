<?php declare(strict_types=1);

namespace Sc\YandexSmartCaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class YandexSmartCaptchaExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->setParameter('captcha.secret_key', $mergedConfig['secret_key']);
        $container->setParameter('captcha.site_key', $mergedConfig['site_key']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('twig')) {
            $container->prependExtensionConfig('twig', ['form_themes' => ['@YandexSmartCaptcha/smartcaptcha_widget.html.twig']]);
        }
    }
}
