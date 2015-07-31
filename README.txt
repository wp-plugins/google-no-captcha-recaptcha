=== Google No CAPTCHA reCAPTCHA by WisdmLabs ===
Contributors: WisdmLabs
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40wisdmlabs%2ecom&lc=US&item_name=WisdmLabs%20Plugin%20Donation&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: nocaptcha recaptcha, contact form 7, Google nocaptcha recaptcha, contact form 7 security, spam filter, antispam, spam blocker, captcha, form security, security, wordpress captcha
Requires at least: 3.9
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin adds a No CAPTCHA reCAPTCHA tag in Contact Form 7, which can be used to include a No CAPTCHA reCAPTCHA anti-spam field.

== Description ==

Research has shown that the reCAPTCHA field can be decoded by smart bots 99% of the time. Google has thus introduced a 'No CAPTCHA reCAPTCHA' API which has a risk analysis engine backing the verification process.
Integrate this API into your Contact Form 7 forms, using this plugin.

* The Google No CAPTCHA reCAPTCHA plugin provides an option to set a custom error message when the CAPTCHA field is not set or if a robot is detected.

* The plugin is localization ready, which means you can display the error message in your local language.

* It also provides support to display the CAPTCHA in multiple languages.

* The plugin is multiform compatible.

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

= Setting up No Captcha reCaptcha =

1. Create domain specific No Captcha reCaptcha key from https://www.google.com/recaptcha/admin#list
2. From your site dashboard, go to Settings > Google No Captcha reCaptcha
3. Enter your site key and secret key and save changes



== Frequently Asked Questions ==

= Where can I find the plugin's settings? =

The plugin's settings can be found under 'Settings -> Google NoCaptcha ReCaptcha Settings'

= Help! I've added the tag, but it doesn't seem to work! =

In case you do not see a No CAPTCHA reCAPTCHA field, kindly ensure that you have added the needed API keys in the plugin settings.

= How do I acquire a Secret Key and Site Key =

In the plugin settings, you'll have to enter a Secret Key and a Site Key. You can get the keys, by logging into a Gmail account and registering your site, using this link: https://www.google.com/recaptcha/admin#list

= How to resize captcha? =

Captcha can be resized by selecting the size during recaptcha tag generation.

= How to set the captcha language? =

Captcha language can be set from 'Settings -> Google NoCaptcha ReCaptcha Settings -> Language'

= How to set custom error message? =

Custom error messages can be set from 'Settings -> Google NoCaptcha ReCaptcha Settings -> Custom Error Messages'

= How to Localize the messages displayed? =

The error messages can be translated using the "goole-nocaptcha-recaptcha-locale.pot" file, present in the languages folder of the plugin.
For translating the message in this file follow the below steps:

1) Convert the .pot file to .mo file and add it to the languages folder of the plugin along with the translated .pot file.

"goole-nocaptcha-recaptcha-locale-<language-code>.mo" and "goole-nocaptcha-recaptcha-locale-<language-code>.pot".

For example, for German, name the files goole-nocaptcha-recaptcha-locale-de_DE.mo and goole-nocaptcha-recaptcha-locale-de_DE.pot

2) Place the .po and .mo file in the languages folder with in plugin folder.

== Screenshots ==

1. No CAPTCHA reCAPTCHA settings page
2. No CAPTCHA reCAPTCHA tag generator in in Contact Form 7
3. No CAPTCHA reCAPTCHA tag in Contact Form 7 backend
4. No CAPTCHA reCAPTCHA field on a Contact Form(Light theme)
5. No CAPTCHA reCAPTCHA field on a Contact Form(Dark theme)

== Changelog ==

= 4.0.3 =
* Fixed captcha resize issue in safari browser.

= 4.0.2 =
* Fixed undefined variable issue.
* Fixed PHP 5.3 incompatibility issue.

= 4.0.1 =
* Fixed Minor Bug

= 4.0 =
* Captcha resize & responsive

= 3.0.3 =
* Fixed Minor Bug

= 3.0.2 =
* Fixed Minor Bug

= 3.0.1 =
* Fixed Minor Bug

= 3.0 =
* Multi-form support
* Resolved Localization issue
* Multi-language support
* Field for custom error message added in admin dashboard settings

= 2.0 =
* Fixed compatibility issue with CF7v4.2+
* file_get_content replaced with wp_remote_post, thanks to @SAM for his contribution [https://wordpress.org/support/topic/validation-problems-8]
* Added id field to the No Captcha reCaptcha pane 
* Fixed Notice "$class variable is not defined in nocaptcha_shortcode_handler() in public/includes/contact-form-7/class-wdm-contact-form-7-public.php on line 173"  
* Made changes to the render_recaptcha.js file for future developement 

= 1.1.2 =
* Extra quote in id="wdm-nocapt-recapt-id"" removed

= 1.1.1 =
* Fixed the issue `Site Breaking while using version 1.1.0`

= 1.1.0 =
* Fixed the issue `Making noCaptcha required with Contact form 7` for [Contact form 7 version 4.1]
* Fixed the issue `i-am-a-robot` where recaptcha returned false every time the form is submited for [PHP 5.6+]

= 1.0.0 =
* Plugin released.





