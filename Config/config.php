<?php

use MauticPlugin\MauticSmsapiBundle\Api\SmsapiApi;
use MauticPlugin\MauticSmsapiBundle\Core\Connection;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiGatewayImpl;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiPluginMauticAdapter;
use MauticPlugin\MauticSmsapiBundle\Integration\SmsapiIntegration;
use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;

return [
    'services' => [
        'other' => [
            'mautic.sms.transport.smsapi' => [
                'class' => SmsapiApi::class,
                'arguments' => [
                    'mautic.sms.smsapi.plugin',
                    'mautic.sms.smsapi.gateway',
                    'monolog.logger.mautic',
                ],
                'tag' => 'mautic.sms_transport',
                'tagArguments' => [
                    'integrationAlias' => MauticSmsapiConst::SMSAPI_INTEGRATION_NAME,
                ],
            ],
            'mautic.sms.smsapi.connection' => [
                'class' => Connection::class,
                'arguments' => [
                    'mautic.sms.smsapi.plugin',
                ],
            ],
            'mautic.sms.smsapi.gateway' => [
                'class' => SmsapiGatewayImpl::class,
                'arguments' => [
                    'mautic.sms.smsapi.connection',
                ],
            ],
            'mautic.sms.smsapi.plugin' => [
                'class' => SmsapiPluginMauticAdapter::class,
                'arguments' => [
                    'mautic.page.model.trackable',
                    'mautic.helper.integration',
                ],
            ],
        ],
        'integrations' => [
            'mautic.integration.smsapi' => [
                'class' => SmsapiIntegration::class,
                'tags' => [
                    'mautic.integration',
                    'mautic.config_integration',
                ],
            ],
        ],
    ],
    'menu' => [
        'main' => [
            'items' => [
                'mautic.sms.smses' => [
                    'route' => 'mautic_sms_index',
                    'access' => ['sms:smses:viewown', 'sms:smses:viewother'],
                    'parent' => 'mautic.core.channels',
                    'checks' => [
                        'integration' => [
                            MauticSmsapiConst::SMSAPI_INTEGRATION_NAME => [
                                'enabled' => true,
                            ],
                        ],
                    ],
                    'priority' => 70,
                ],
            ],
        ],
    ],
    'parameters' => [
        'sms_transport' => 'mautic.sms.transport.smsapi',
    ],
];
