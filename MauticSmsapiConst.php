<?php

namespace MauticPlugin\MauticSmsapiBundle;

class MauticSmsapiConst
{
    const SMSAPI_INTEGRATION_NAME = 'Smsapi';

    const SMSAPI_URL = 'https://smsapi.io/api/';

    const OAUTH_SERVICE = 'https://oauth.smsapi.io';
    const OAUTH_SCOPES = 'sms,profile,sms_sender';
    const OAUTH_API_TOKEN_URL = self::OAUTH_SERVICE . '/api/oauth/token';
    const OAUTH_AUTHENTICATION_URL = self::OAUTH_SERVICE . '/oauth/access';

    const CONFIG_SENDERNAME = 'sendername';
}
