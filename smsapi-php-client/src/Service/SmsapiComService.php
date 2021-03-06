<?php

declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Feature\Hlr\HlrFeature;
use Smsapi\Client\Feature\Ping\PingFeature;
use Smsapi\Client\Feature\Profile\ProfileFeature;
use Smsapi\Client\Feature\Push\PushFeature;
use Smsapi\Client\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Feature\Sms\SmsFeature;
use Smsapi\Client\Feature\Subusers\SubusersFeature;

/**
 * @api
 */
interface SmsapiComService
{
    public function pingFeature(): PingFeature;

    public function smsFeature(): SmsFeature;

    public function hlrFeature(): HlrFeature;

    public function subusersFeature(): SubusersFeature;

    public function profileFeature(): ProfileFeature;

    public function shortUrlFeature(): ShortUrlFeature;

    public function contactsFeature(): ContactsFeature;

    public function pushFeature(): PushFeature;
}
