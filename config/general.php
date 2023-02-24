<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\config\GeneralConfig;
use craft\helpers\App;

$isDev = App::env('CRAFT_ENVIRONMENT') === 'dev';
$isProd = App::env('CRAFT_ENVIRONMENT') === 'production';

return GeneralConfig::create()
    ->addTrailingSlashesToUrls()
    ->autoLoginAfterAccountActivation()
    ->backupOnUpdate(false)
    ->convertFilenamesToAscii()
    ->cpTrigger('esm')
    ->defaultTemplateExtensions(['html', 'twig', 'html.twig'])
    ->defaultWeekStartDay(1)
    ->enableCsrfProtection()
    ->enableGql(false)
    ->errorTemplatePrefix('_views/errors/')
    ->generateTransformsBeforePageLoad()
    ->limitAutoSlugsToAscii()
    ->omitScriptNameInUrls()
    ->pageTrigger('?p')
    ->revAssetUrls()
    ->requireMatchingUserAgentForSession(false)
    ->runQueueAutomatically(false)
    ->securityKey(App::env('CRAFT_SECURITY_KEY'))
    ->sendPoweredByHeader(false)
    ->transformGifs(false)
    ->useEmailAsUsername()

    // Development
    ->devMode($isDev)
    ->cacheDuration($isDev ? 1 : 86400)

    // Non production
    ->allowAdminChanges(!$isProd)
    ->disallowRobots(!$isProd);
