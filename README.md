# mediawiki-extensions-ErrorPage

This extension shows the error-page on a non-existing page

## Install
See how to [install extensions](https://www.mediawiki.org/wiki/Manual:Extensions#Installing_an_extension)

Download, unpack, rename the unpacked directory to `ErrorPage` and then just put this directory with the scripts into `MediaWiki` extensions directory.

Find the `LocalSettings.php` file in the root of `MediaWiki` directory and paste this code
```php
wfLoadExtension( 'ErrorPage' );
```

That's all. This extension is not using the upgradable mechanism. You don't need to find out how to run `upgrading an extension`
