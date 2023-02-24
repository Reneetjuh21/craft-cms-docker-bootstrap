<?php
declare(strict_types=1);

namespace modules\sitemodule\services;

use craft\base\Component;
use craft\elements\Entry;

class CompetitionService extends Component
{
    public function competitionExists(string $code): bool
    {
        return Entry::find()
            ->section('competitions')
            ->competitionCode($code)
            ->exists();
    }
}