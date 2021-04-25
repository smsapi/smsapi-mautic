# SMSAPI plugin for Mautic

Integration [SMSAPI.pl](https://www.smsapi.pl) and [SMSAPI.com](https://www.smsapi.com) with Mautic.

## Requirements

1. Mautic 3
2. PHP 7+

## Installation

1. Download https://github.com/smsapi/smsapi-mautic/archive/refs/heads/mautic-v3.zip
2. Extract it to plugins/MauticSmsapiBundle
3. Delete  cache `php bin/console cache:clear`
3. Run `php bin/console mautic:plugins:install`
4. Go to Plugins in Mautic's admin menu (/s/plugins)
5. Click on SMSAPI, publish, and configure OAuth credentials (contact with SMSAPI support for Client ID and Client Secret)
6. Connect with SMSAPI by click on button Authorize App and confirm access on SMSAPI page 
7. Go to Mautic's Configuration (/s/config/edit), click on the Text Message Settings, then choose SMSAPI as the default transport.
