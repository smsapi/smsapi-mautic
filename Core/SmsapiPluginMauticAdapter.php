<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use Mautic\PageBundle\Model\TrackableModel;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticSmsapiBundle\Integration\SmsapiIntegration;
use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;

class SmsapiPluginMauticAdapter implements SmsapiPluginInterface
{
    private $pageTrackableModel;
    private $integrationHelper;

    public function __construct(TrackableModel $pageTrackableModel, IntegrationHelper $integrationHelper)
    {
        $this->pageTrackableModel = $pageTrackableModel;
        $this->integrationHelper = $integrationHelper;
    }

    public function isPublished(): bool
    {
        $integration = $this->integration();

        return $integration->getIntegrationSettings()->getIsPublished();
    }

    private function integration(): SmsapiIntegration
    {
        return $this->integrationHelper->getIntegrationObject(MauticSmsapiConst::SMSAPI_INTEGRATION_NAME);
    }

    public function getPageTrackableModel(): TrackableModel
    {
        return $this->pageTrackableModel;
    }

    public function getSendername(): string
    {
        $sendernameConfig = MauticSmsapiConst::CONFIG_SENDERNAME;

        return $this->config($sendernameConfig);
    }

    private function config(string $keyName, string $default = '')
    {
        $integration = $this->integration();

        $featureSettings = $integration->getIntegrationSettings()->getFeatureSettings();

        return $featureSettings[$keyName] ?? $default;
    }

    public function getBearerToken(): string
    {
        $integration = $this->integration();

        return (string)$integration->getBearerToken();
    }

    public function getServiceName(): string
    {
        return MauticSmsapiConst::SMSAPI_INTEGRATION_NAME;
    }
}
