<?php
declare(strict_types=1);

namespace modules\sitemodule\services;

use craft\base\Component;
use craft\elements\Entry;

class TeamService extends Component
{
    public function getTeamByCode(string $code): ?Entry
    {
        return Entry::find()
            ->section('teams')
            ->teamCode($code)
            ->one();
    }

    public function createTeam(string $teamName, string $teamCode = null, Entry $club = null): Entry
    {
        $team = new Entry();
        $team->section = 'teams';
        $team->title = $teamName;

        if ($teamCode) {
            $team->teamCode = $teamCode;
        }

        if ($club) {
            $team->club = $club;
        }

        return $team;
    }
}