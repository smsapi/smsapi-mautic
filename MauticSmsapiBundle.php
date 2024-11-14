<?php

namespace MauticPlugin\MauticSmsapiBundle;

use Mautic\IntegrationsBundle\Bundle\AbstractPluginBundle;

class MauticSmsapiBundle extends AbstractPluginBundle
{
    public function boot()
    {
        include_once __DIR__.'/smsapi-php-client/vendor/autoload.php';
    }
}
