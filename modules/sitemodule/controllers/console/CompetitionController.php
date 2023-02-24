<?php
declare(strict_types=1);

namespace modules\sitemodule\controllers\console;

use craft\console\Controller;
use modules\sitemodule\Sitemodule;
use yii\console\ExitCode;

class CompetitionController extends Controller
{
    public function actionGetCompetitions(): int
    {
        $club = Sitemodule::$instance->clubService->getOwnClub();
        $competitions = Sitemodule::$instance->apiService->send('GET', 'teams');
        return ExitCode::OK;
    }
}