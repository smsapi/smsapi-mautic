<?php

namespace MauticPlugin\MauticSmsapiBundle;

class MauticSmsapiConst
{
    const SERVICE_SMSAPI_PL = 'smsapi.pl';
    const SERVICE_SMSAPI_COM = 'smsapi.com';

    const DOMAIN_SMSAPI_PL = 'https://ssl.smsapi.pl/';
    const DOMAIN_SMSAPI_COM = 'https://ssl.smsapi.com/';

    const SMSAPI_INTEGRATION_NAME = 'Smsapi';

    const OAUTH_SCOPES = 'sms';
    const OAUTH_API_TOKEN_URL = 'api/oauth/token';
    const OAUTH_AUTHENTICATION_URL = 'oauth/access';

    const CONFIG_SERVICE = 'service_instance';
    const CONFIG_SENDERNAME = 'sendername';
}
