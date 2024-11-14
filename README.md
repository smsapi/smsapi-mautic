# SMSAPI plugin for Mautic

Integration [SMSAPI.pl](https://www.smsapi.pl) and [SMSAPI.com](https://www.smsapi.com) with Mautic.

## Requirements

1. Mautic 5
2. PHP 8+

## Installation

1. Download the latest plugin version: https://github.com/smsapi/smsapi-mautic/archive/refs/heads/mautic-v5.zip.
2. Extract the downloaded file to plugins/MauticSmsapiBundle.
3. Clear the cache by running: php bin/console cache:clear.
4. Install the plugin by running: php bin/console mautic:plugins:install.
5. In Mautic's admin menu, go to Plugins (/s/plugins).
6. Click on SMSAPI, enter your access token, and publish the plugin.
7. Go to Mautic's Configuration (/s/config/edit), open Text Message Settings, and select SMSAPI as the default transport.

### Integration with old Mautic versions

[Documentation](https://github.com/smsapi/smsapi-mautic/tree/mautic-v2) for SMSAPI integration with Mautic version 2. 

[Documentation](https://github.com/smsapi/smsapi-mautic/tree/mautic-v3) for SMSAPI integration with Mautic version 3.

[Documentation](https://github.com/smsapi/smsapi-mautic/tree/mautic-v4) for SMSAPI integration with Mautic version 4. 

