potcoinstatswidget
===================

Wordpress plugin to show POT/USD and POT/BTC exchange rates

Installation
-------------------

1. Download Zip
2. Upload and extract to wp-content/plugins/potcoinstatswidget or use Wordpress' built in plugin installer
3. Activate plugin in Wordpress (Plugins -> Installed Plugins -> Potcoin Stats Widget -> Activate)

Configuration
-------------------

First you have to generate an API key on at least one of the websites the widget fetches data from. Currently the following sources are used:

POT/BTC
 * http://cryptorush.in/ (private, key needed)
 * http://swisscex.com/ (private, key needed)

BTC/USD
 * http://blockchain.info/ (public)
 * http://bitcoinaverage.com/ (public)

For the plugin to work a source for POT/BTC data and one for BTC/USD data is required. Sources marked with 'public' do not require an api key while those marked as 'private' do. Go to the following locations to generate an API key.

* Swisscex: https://www.swisscex.com/profile/configuration/
* Cryptorush: https://cryptorush.in/index.php?p=settings

You are not required to enter an API key for both sites but you NEED at least one. For cryptorush.in the user id number is also required, should be present on the same page as the API key.

When you have generated your API key, copy it in your clipboard, then head over to your wordpress sites' settings. Paste the key in the section for the site you generated the API key on.

Press Save Changes.

The exchange rates are cached in the database for 15 minutes.

The last step is to drag the widget to a widget area (Appearance -> Widgets -> Potcoin Exchange Rate). For example your sidebar. Optionally set another title, if not then "Potcoin Exchange Rate" will be used as default. Click save and you're done. Enjoy the view!

<img src="http://i.imgur.com/6IxCdEu.png">

Potcoin Stats Widget under TwentyFourteen theme.

Changelog
-------------------

1.0 2014-02-16 Initial release

1.1 2014-03-05 Added database caching of api requests and new exchange (http://swisscex.com/)
