<?php

namespace MauticPlugin\MauticSmsapiBundle\Api;

use Mautic\LeadBundle\Entity\Lead;
use Mautic\SmsBundle\Sms\TransportInterface;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiGateway;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiPluginInterface;
use Monolog\Logger;
use Smsapi\Client\SmsapiClientException;

class SmsapiApi implements TransportInterface
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
    }

    public function sendSms(Lead $lead, $content)
    {
        $isPublished = $this->smsApiPlugin->isPublished();
        if (!$isPublished) {
            return false;
        }

        $sendername = $this->smsApiPlugin->getSendername();
        $phoneNumber = $lead->getLeadPhoneNumber();
        if ($phoneNumber === null) {
            return false;
        }

        try {
            $this->smsApiGateway->sendSms($phoneNumber, $content, $sendername);
            $this->logger->notice('Send SMS to ' . $lead->getName() . ' on number ' . $phoneNumber);
        } catch (SmsapiClientException $clientException) {
            $this->logger->error('Send SMS to ' . $lead->getName() . ' fail' . $clientException->getMessage());

            return $clientException->getMessage();
        }

        return true;
    }
}
