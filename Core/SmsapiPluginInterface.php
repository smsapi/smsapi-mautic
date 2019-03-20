<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use Mautic\PageBundle\Model\TrackableModel;

interface SmsapiPluginInterface
{
    public function isPublished(): bool;

    public function getBearerToken(): string;

    public function getPageTrackableModel(): TrackableModel;

    public function getSendername(): string;

    public function getServiceName(): string;
}
