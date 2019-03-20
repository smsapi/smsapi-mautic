# SMSAPI plugin for Mautic

Integration SMSAPI.pl and SMSAPI.com with Mautic.

## Requirements

1. Mautic 2.15.0
2. PHP 7+

## Installation

1. Download https://github.com/smsapi/smsapi-mautic/archive/master.zip
2. Extract it to plugins/MauticSmsapiBundle
3. Delete  cache `php app/console cache:clear`
3. Run `php app/console mautic:plugins:install`
4. Go to Plugins in Mautic's admin menu (/s/plugins)
5. Click on SMSAPI, publish, and configure it with the requested information including selecting the custom field created above
6. Go to Mautic's Configuration (/s/config/edit), click on the Text Message Settings, then choose SMSAPI as the default transport.
