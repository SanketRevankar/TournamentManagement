<?php
$SITE_NAME = 'Tournament Manager'; // Name of your site

$FIXTURES_LINK = '#'; // Fixtures link to redirect to for match fixtures

$PROJECT_ID = ''; // Google Cloud Project ID for App Engine

$STEAM_API = ''; // Your Steam WebAPI-Key found at https://steamcommunity.com/dev/apikey

$WEBSITE_LINK = ''; // The main URL of your website displayed in the login page

$FB_APP_ID = ''; // Visit https://developers.facebook.com/ -> My Apps -> Add new App to create a new app and get its app ID

$MAX_PLAYERS = 30; // Max players in a team

$MODE = 0;
/*
 * 0 -> Normal Team mode
 * 1 -> Registrations closed for team mode
 * 9 -> Registrations closed for team mode with no changes in team
 *
 * 2 -> Registrations closed for solo registration   => Not Tested
 * 3 -> Normal solo registration                     => Not Tested
 */

// Configuration Validation. Do not remove!
if (empty($PROJECT_ID)) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>Configuration:<br>Please enter project-id!<br>Find this in globals.php</div>");}
if (empty($STEAM_API)) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>Configuration:<br>Please enter Steam API key!<br>Find this in globals.php</div>");}
if (empty($WEBSITE_LINK)) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>Configuration:<br>Please enter the website link!<br>Find this in globals.php</div>");}
if (empty($FB_APP_ID)) {die("<div style='display: block; width: 100%; background-color: red; text-align: center;'>Configuration:<br>Please enter Facebook API Key!<br>Find this in globals.php</div>");}
