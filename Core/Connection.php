<?php

namespace MauticPlugin\MauticSmsapiBundle\Core;
use Smsapi\Client\Curl\SmsapiHttpClient;
use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;
use RuntimeException;
use Smsapi\Client\Service\SmsapiComService;
use Smsapi\Client\Service\SmsapiPlService;

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
        return (new SmsapiHttpClient())->smsapiPlServiceWithUri($apiToken,MauticSmsapiConst::SMSAPI_URL);
    }
}
