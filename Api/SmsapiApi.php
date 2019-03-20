<?php

namespace MauticPlugin\MauticSmsapiBundle\Api;

use Mautic\LeadBundle\Entity\Lead;
use Mautic\SmsBundle\Api\AbstractSmsApi;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiGateway;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiPluginInterface;
use Monolog\Logger;
use Smsapi\Client\SmsapiClientException;

class SmsapiApi extends AbstractSmsApi
{
    private $logger;
    private $smsApiGateway;
    private $smsApiPlugin;

    public function __construct(
        SmsapiPluginInterface $smsApiPlugin,
        SmsapiGateway $smsApiGateway,
        Logger $logger
    ) {
        $this->logger = $logger;
        $this->smsApiGateway = $smsApiGateway;
        $this->smsApiPlugin = $smsApiPlugin;
        parent::__construct($smsApiPlugin->getPageTrackableModel());
    }

    public function sendSms(Lead $lead, $content)
    {
        $isPublished = $this->smsApiPlugin->isPublished();
        if (!$isPublished) {
            return false;
        }

        $sendername = $this->smsApiPlugin->getSendername();

        try {
            $this->smsApiGateway->sendSms($lead->getPhone(), $content, $sendername);
            $this->logger->notice('Send SMS to ' . $lead->getName() . ' on number ' . $lead->getPhone());
        } catch (SmsapiClientException $clientException) {
            $this->logger->error('Send SMS to ' . $lead->getName() . ' fail' . $clientException->getMessage());

            return $clientException->getMessage();
        }
    }
}
