<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use MauticPlugin\MauticSmsapiBundle\DataObject\Profile;

class SmsapiGatewayDecorator implements SmsapiGateway
{
    private $gateway;
    private $plugin;

    public function __construct(SmsapiGatewayImpl $gatewayImpl, SmsapiPluginInterface $plugin)
    {
        $this->gateway = $gatewayImpl;
        $this->plugin = $plugin;
    }

    public function isConnected(): bool
    {
        if (!$this->plugin->getBearerToken()) {
            return false;
        }

        return $this->gateway->isConnected();
    }

    public function getSendernames(): array
    {
        return $this->gateway->getSendernames();
    }

    public function sendSms(string $phoneNumber, string $content, string $sendername)
    {
        $this->gateway->sendSms($phoneNumber, $content, $sendername);
    }

    public function getProfile(): Profile
    {
        return $this->gateway->getProfile();
    }
}
