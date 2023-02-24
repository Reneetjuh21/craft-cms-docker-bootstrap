<?php

declare(strict_types=1);

namespace modules\sitemodule;

use craft\events\RegisterTemplateRootsEvent;
use craft\web\View;
use modules\sitemodule\services\ApiService;
use modules\sitemodule\services\ClubService;
use modules\sitemodule\services\CompetitionService;
use modules\sitemodule\services\TeamService;
use yii\base\Event;
use yii\base\Module;

/**
 * @property ApiService $apiService
 * @property TeamService $teamService
 * @property CompetitionService $competitionService
 * @property ClubService $clubService
 */
class Sitemodule extends Module
{
    public static Sitemodule $instance;

    public function __construct($id, $parent = null, array $config = [])
    {
        \Craft::setAlias('@modules/sitemodule', $this->getBasePath());

        $this->controllerNamespace = 'modules\sitemodule\controllers';
        if (\Craft::$app->getRequest()->getIsConsoleRequest()) {
            $this->controllerNamespace .= '\console';
        }

        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, static function (RegisterTemplateRootsEvent $event) {
            $event->roots = array_merge($event->roots, [
                'sitemodule' => __DIR__ . '/templates',
            ]);
        });

        static::setInstance($this);
        parent::__construct($id, $parent, $config);
    }

    public function init(): void
    {
        parent::init();
        self::$instance = $this;
    }
}
