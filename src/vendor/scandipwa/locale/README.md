# ScandiPWA Locale

The ScandiPWA is using different bundles per language. This module is here to handle bundle switching to the specified store language.

## Feature breakdown:

**1. Switches language per store**

Exposes `$this->getStaticBundleFile()` in generated `Magento_Theme/templates/root.phtml`.
It does so from themes `index.production.html` - so find PHP source there.

**2. Adds helper to get static versioned files**

The `$this->getStaticFile($url)`, where `$url` is relative to `Magento_Theme` folder
(generated with `npm run build`) allows to pass generated files to it.

**3. Optimizes static-content deploy**

If theme is specified, the static-content deploy wont process all files.
It decreases the processed file amount form 2k down to 20-30.

This can be achieved using following command:

```
magento setup:static-content:deploy -t Scandiweb/pwa
```