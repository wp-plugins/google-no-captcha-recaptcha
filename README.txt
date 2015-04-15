=== Google No CAPTCHA reCAPTCHA by WisdmLabs ===
Contributors: WisdmLabs
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40wisdmlabs%2ecom&lc=US&item_name=WisdmLabs%20Plugin%20Donation&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: nocaptcha recaptcha, contact form 7
Requires at least: 3.9
Tested up to: 4.1.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin adds a No CAPTCHA reCAPTCHA tag in Contact Form 7, which can be used to include a No CAPTCHA reCAPTCHA anti-spam field.

== Description ==

Research has shown that the reCAPTCHA field can be decoded by smart bots 99% of the time. Google has thus introduced a 'No CAPTCHA reCAPTCHA' API which has a risk analysis engine backing the verification process.
Integrate this API into your Contact Form 7 forms, using this plugin.

* This Google No CAPTCHA reCAPTCHA plugin is localization ready, however currently supports CAPTCHA strings only in English.

* The plugin is multisite compatible. Do ensure that you add the keys for every sub-domain in the plugin's settings.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'google-nocaptcha-recaptcha'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `google-nocaptcha-recaptcha.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `google-nocaptcha-recaptcha.zip`
2. Extract the `google-nocaptcha-recaptcha` directory to your computer
3. Upload the `google-nocaptcha-recaptcha` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==

= Help! I've added the tag, but it doesn't seem to work! =

In case you do not see a No CAPTCHA reCAPTCHA field, kindly ensure that you have added the needed API keys in the plugin settings.

= Where can I find the plugin's settings? =

The plugin's settings can be found under 'Settings -> Google NoCaptcha ReCaptcha Settings'

= How do I acquire a Secret Key and Site Key =

In the plugin settings, you'll have to enter a Secret Key and a Site Key. You can get the keys, by logging into a Gmail account and registering your site, using this link: https://www.google.com/recaptcha/admin#list

== Screenshots ==

1. The No CAPTCHA reCAPTCHA tag in Contact Form 7
2. The No CAPTCHA reCAPTCHA field on a Contact Form

== Changelog ==

= 1.0.0 =
* Plugin released.

= 1.1.0 =
* Fixed the issue `Making noCaptcha required with Contact form 7` for [Contact form 7 version 4.1]
* Fixed the issue `i-am-a-robot` where recaptcha returned false every time the form is submited for [PHP 5.6+]

= 1.1.1 =
* Fixed the issue `Site Breaking while using version 1.1.0`
 