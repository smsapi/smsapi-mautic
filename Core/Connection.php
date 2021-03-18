<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;

use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;
use RuntimeException;
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
        if(!$apiToken) {
            throw new RuntimeException('Api token not available');
        }
        $httpClient = new SmsapiHttpClient();

        return $httpClient->smsapiPlServiceWithUri($apiToken,MauticSmsapiConst::SMSAPI_URL);
    }
}
