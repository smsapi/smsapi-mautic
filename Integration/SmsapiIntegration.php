<?php

namespace MauticPlugin\MauticSmsapiBundle\Integration;

use Doctrine\ORM\EntityManager;
use Mautic\CoreBundle\Helper\CacheStorageHelper;
use Mautic\CoreBundle\Helper\EncryptionHelper;
use Mautic\CoreBundle\Helper\PathsHelper;
use Mautic\CoreBundle\Model\NotificationModel;
use Mautic\CoreBundle\Translation\Translator;
use Mautic\IntegrationsBundle\Integration\ConfigurationTrait;
use Mautic\IntegrationsBundle\Integration\Interfaces\ConfigFormInterface;
use Mautic\LeadBundle\Model\CompanyModel;
use Mautic\LeadBundle\Model\DoNotContact as DoNotContactModel;
use Mautic\LeadBundle\Model\FieldModel;
use Mautic\LeadBundle\Model\LeadModel;
use Mautic\PluginBundle\Integration\AbstractIntegration;
use Mautic\PluginBundle\Model\IntegrationEntityModel;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiGateway;
use MauticPlugin\MauticSmsapiBundle\Core\SmsapiPluginInterface;
use MauticPlugin\MauticSmsapiBundle\MauticSmsapiConst;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Router;
use Symfony\Component\Translation\TranslatorInterface;


class SmsapiIntegration extends AbstractIntegration implements ConfigFormInterface
{
    use ConfigurationTrait;
    /**
     * @var SmsapiGateway
     */
    private $gateway;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        CacheStorageHelper $cacheStorageHelper,
        EntityManager $entityManager,
        Session $session,
        RequestStack $requestStack,
        Router $router,
        Translator $translator,
        Logger $logger,
        EncryptionHelper $encryptionHelper,
        LeadModel $leadModel,
        CompanyModel $companyModel,
        PathsHelper $pathsHelper,
        NotificationModel $notificationModel,
        FieldModel $fieldModel,
        IntegrationEntityModel $integrationEntityModel,
        DoNotContactModel $doNotContact,
        SmsapiGateway $gateway
    ) {
        parent::__construct($eventDispatcher, $cacheStorageHelper, $entityManager, $session, $requestStack, $router,
            $translator, $logger, $encryptionHelper, $leadModel, $companyModel, $pathsHelper, $notificationModel,
            $fieldModel, $integrationEntityModel, $doNotContact);
        $this->gateway = $gateway;
    }

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

    public function getBearerToken($inAuthorization = false)
    {
        if (!$inAuthorization && isset($this->keys['API-Token'])) {
            return $this->keys['API-Token'];
        }

        return false;
    }

    public function getFormSettings(): array
    {
        return [
            'requires_callback' => false,
            'requires_authorization' => false,
        ];
    }

    /**
     * Get a list of keys required to make an API call.  Examples are key, clientId, clientSecret.
     *
     * @return array
     */
    public function getRequiredKeyFields()
    {
        return [
            'API-Token' => 'mautic.sms.config.form.sms.smsapi.token',
        ];
    }

    /**
     * @return array
     */
    public function getSecretKeys()
    {
        return [
            'API-Token',
        ];
    }

    public function getAuthenticationType(): string
    {
        return 'none';
    }

    public function appendToForm(&$builder, $data, $formArea):void
    {
        $isConnected = $this->gateway->isConnected();

        if ($formArea == 'keys') {
            $builder->add(
                'connection_status',
                TextType::class,
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

        $sendernames = $this->gateway->getSendernames();
        $profile = $this->gateway->getProfile();


        if ($formArea == 'features') {
            $builder->add(
                'available_points',
                TextType::class,
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

    public function getConfigFormName(): ?string
    {
        return null;
    }

    public function getConfigFormContentTemplate(): ?string
    {
        return null;
    }
}

