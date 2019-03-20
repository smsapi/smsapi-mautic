<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiPlService;
use Smsapi\Client\SmsapiHttpClient;

class Connection
{
    private $integrationHelper;

    public function __construct(SmsapiPluginInterface $integrationHelper)
    {
        $this->integrationHelper = $integrationHelper;
    }

    /**
     * @return SmsapiComService|SmsapiPlService
     */
    public function smsapiClient()
    {
        $apiToken = $this->integrationHelper->getBearerToken();

        return $this->createClient($apiToken);
    }

    /**
     * @param string $apiToken
     * @return SmsapiComService|SmsapiPlService
     */
    private function createClient(string $apiToken)
    {
        $httpClient = new SmsapiHttpClient();
        if ($this->integrationHelper->getServiceName() === MauticSmsapiConst::SERVICE_SMSAPI_PL) {
            $service = $httpClient->smsapiPlService($apiToken);
        } else {
            $service = $httpClient->smsapiComService($apiToken);
        }

        return $service;
    }
}
