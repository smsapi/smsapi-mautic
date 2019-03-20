<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

interface SmsapiGateway
{
    public function isConnected(): bool;

    public function sendSms(string $phoneNumber, string $content, string $sendername);

    public function getSendernames(): array;

    public function getProfile(): Profile;
}
