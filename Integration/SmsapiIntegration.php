<?php

namespace MauticPlugin\MauticSmsapiBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiGateway;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiPluginInterface;
use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SmsapiIntegration extends AbstractIntegration
{
    public function getName(): string
    {
        return MauticSmsapiConst::SMSAPI_INTEGRATION_NAME;
    }

    public function getDisplayName(): string
    {
        return 'SMSAPI';
    }

    public function getIcon(): string
    {
        return 'plugins/MauticSmsapiBundle/Assets/img/smsapi.png';
    }

    public function adapter(): SmsapiPluginInterface
    {
        return $this->factory->get('mautic.sms.smsapi.plugin');
    }

    public function getSecretKeys(): array
    {
        return ['password'];
    }

    public function getAuthenticationUrl(): string
    {
        return MauticSmsapiConst::OAUTH_AUTHENTICATION_URL;
    }

    public function getAccessTokenUrl(): string
    {
        return MauticSmsapiConst::OAUTH_API_TOKEN_URL;
    }

    public function getAuthScope(): string
    {
        return MauticSmsapiConst::OAUTH_SCOPES;
    }

    public function getBearerToken($inAuthorization = false)
    {
        if (!$inAuthorization && isset($this->keys[$this->getAuthTokenKey()])) {
            return $this->keys[$this->getAuthTokenKey()];
        }

        return false;
    }

    public function getFormSettings(): array
    {
        return [
            'requires_callback' => false,
            'requires_authorization' => true,
        ];
    }

    public function getAuthenticationType(): string
    {
        return 'oauth2';
    }

    public function appendToForm(&$builder, $data, $formArea)
    {
        /**
         * @var $smsApiGateway SmsapiGateway
         */
        $smsApiGateway = $this->factory->get('mautic.sms.smsapi.gateway');

        $isConnected = $smsApiGateway->isConnected();

        if ($formArea == 'keys') {
            $builder->add(
                'connection_status',
                'text',
                [
                    'label' => 'mautic.sms.config.form.sms.smsapi.connection_status',
                    'label_attr' => ['class' => 'control-label'],
                    'disabled' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'data' => $isConnected ?
                        $this->translator->trans('mautic.sms.config.form.sms.smsapi.success_authenticated')
                        : $this->translator->trans('mautic.sms.config.form.sms.smsapi.no_authentication'),
                ]
            );
        }

        if (!$isConnected) {
            return;
        }

        $sendernames = $smsApiGateway->getSendernames();
        $profile = $smsApiGateway->getProfile();


        if ($formArea == 'features') {
            $builder->add(
                'available_points',
                'number',
                [
                    'label' => 'mautic.sms.config.form.sms.smsapi.available_points',
                    'label_attr' => ['class' => 'control-label'],
                    'disabled' => true,
                    'required' => false,
                    'attr' => [
                        'class' => ' form-control',
                    ],
                    'data' => $profile->points,
                ]
            );
            $builder->add(
                'sendername',
                ChoiceType::class,
                [
                    'label' => 'mautic.sms.config.form.sms.smsapi.sendername',
                    'label_attr' => ['class' => 'control-label'],
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => $sendernames,
                ]
            );
        }
    }
}

