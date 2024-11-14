<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use MauticPlugin\MauticSmsapiBundle\DataObject\Profile;

interface SmsapiGateway
{
    public function isConnected(): bool;

    public function sendSms(string $phoneNumber, string $content, string $sendername);

    public function getSendernames(): array;

    public function getProfile(): Profile;
}
