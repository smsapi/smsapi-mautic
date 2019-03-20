<?php

namespace MauticPlugin\MauticSmsapiBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;

class MauticSmsapiBundle extends PluginBundleBase
{
    public function boot()
    {
        include_once 'smsapi-php-client/vendor/autoload.php';
    }
}
