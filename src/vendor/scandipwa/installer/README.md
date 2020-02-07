# ScandiPWA installer
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fscandipwa%2Finstaller.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fscandipwa%2Finstaller?ref=badge_shield)


Module is a helper to install ScandiPWA Theme.

## 1.2.0 update
Version `1.2.0` introduce changes to theme registration logic, related to URL rewrite functionality.

`theme.xml` got custom `<pwa>true</pwa>` node, that is forcing custom theme type.
In order to simply update already installed theme, update `theme` table in the database, setting up `type` = `4` for 
your PWA theme. Cache flush is necessary once done!

## Usage

`composer require scandipwa/installer`

After installation flush the caches (Varnish or filesystem).

`scandipwa:theme:bootstrap` must appear in your Magento 2 CLI command list
`php bin/magento`

### New theme bootstrap

Command accepts single parameter, which is treated as following format: "Vendor/theme".

**Note**

*You can change `Scandiweb/pwa` in examples below to anything suitable for you, keeping the same naming structure: 
`Vendor/theme_name`*

After `php bin/magento scandipwa:theme:bootstrap Scandiweb/pwa` it will make next effect:
1. Check for `<magento_root>/app/design/frontend/Scandiweb/pwa` - bootstrap will quite with error if directory is present to prevent unwanted overrides.
2. Create `<magento_root>/app/design/frontend/Scandiweb/pwa` directory
3. Copy necessary files to the newly created theme root.
4. Answer y/N (No is default) to a prompt for `theme.xml` and `registration.php` generation. You might want to create
 them manually - feel free to do it!
5. Run `php bin/magento setup:upgrade`.
6. You are bootstraped!

### Theme build
The theme must be built after it is bootstrap or after any changes.

1. Go to `app/design/frontend/Scandiweb/pwa` (or your custom `Vendor/theme_name`)
2. run `npm ci`
3. run `npm run build`

### DEMO installation

If you'd like to get the same result as [v1.scandipwa.com](https://v1.scandipwa.com) you must import database 
[dump](https://github.com/scandipwa/scandipwa-base/raw/master/deploy/latest.sql) and get 
[media](https://s3-eu-west-1.amazonaws.com/scandipwa-public-assets/scandipwa_media.tgz)


#### Customization
In order to customize copying task - simply edit `di.xml`, passing array with paths.

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fscandipwa%2Finstaller.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fscandipwa%2Finstaller?ref=badge_large)