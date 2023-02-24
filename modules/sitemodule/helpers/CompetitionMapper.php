<?php
declare(strict_types=1);

namespace modules\sitemodule\helpers;

use craft\elements\Entry;
use craft\models\Site;
use modules\sitemodule\Sitemodule;

class CompetitionMapper
{
    public static function mapToCompetitionEntries(array $data): array
    {
        $teamService = Sitemodule::$instance->teamService;
        $clubService = Sitemodule::$instance->clubService;
        $competitionService = Sitemodule::$instance->competitionService;
        $competitions = [];
        foreach($data as $object) {
            if ($competitionService->competitionExists($object['poulecode'])) {
                continue;
            }

            $competition = new Entry();
            $competition->section = 'competitions';
            $competition->competitionCode = $object['poulecode'];
            $competitionTeams = Sitemodule::$instance->apiService->send('GET', 'poule-indeling', [], [], ['poulecode' => $object['poulecode']]);

            foreach($competitionTeams as $competitionTeam) {
                $club =
                    $clubService->getClubByCode($competitionTeam['clubrelatiecode'])
                    ??

                $team = $teamService->getTeamByCode($competitionTeam['teamcode']) ?? $teamService->createTeam(
                    $competitionTeam['teamnaam'],
                    $competitionTeam['eigenteam'] ? $object['teamcode'] : null,
                    $club
                );
                $team->competitions->add($competition);
            }
        }
        return $competitions;
    }

    private function mapClub(string $code): Entry
    {
        $clubData = Sitemodule::$instance->apiService->send('GET', '')
    }
}