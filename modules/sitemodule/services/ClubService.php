<?php
declare(strict_types=1);

namespace modules\sitemodule\services;

use Craft;
use craft\base\Component;
use craft\elements\Entry;
use modules\sitemodule\helpers\ImageHelper;
use modules\sitemodule\Sitemodule;

class ClubService extends Component
{
    public function getOwnClub(): Entry
    {
        $entry = Entry::find()
            ->section('clubs')
            ->isOwnClub(true)
            ->one();

        if (!$entry) {
            $clubDetails = Sitemodule::$instance->apiService->send('GET', 'clubgegevens');
            $entry = $this->createClub(
                $clubDetails['gegevens']['clubnaam'],
                $clubDetails['gegevens']['clubcode'],
                $clubDetails['gegevens']['telefoonnummer'],
                $clubDetails['gegevens']['email'],
                $clubDetails['bezoekadres']['route'],
                sprintf(
                    '%s %s-%s, %s %s',
                    $clubDetails['bezoekadres']['straatnaam'],
                    $clubDetails['bezoekadres']['huisnummer'],
                    $clubDetails['bezoekadres']['nummertoevoeging'],
                    $clubDetails['bezoekadres']['postcode'],
                    $clubDetails['bezoekadres']['plaats'],
                ),
                $clubDetails['gegevens']['logo'],
                true
            );
            Craft::$app->getElements()->saveElement($entry);
        }
        return $entry;
    }

    public function getClubByCode(string $code): ?Entry
    {
        return Entry::find()
            ->section('clubs')
            ->clubCode($code)
            ->one();
    }

    public function createClub(
        string $clubName,
        string $clubCode,
        string $phone,
        string $email,
        string $route,
        string $address,
        string $logo = null,
        bool $isOwnClub = false
    ): Entry {
        $club = new Entry();
        $club->sectionId = (Craft::$app->sections->getSectionByHandle('clubs'))->id;
        $club->title = $clubName;
        $club->clubCode = $clubCode;
        $club->isOwnClub = $isOwnClub;
        $club->phone = $phone;
        $club->email = $email;
        $club->clubRoute = $route;
        $club->address = $address;
        $club->clubLogo = [
            (ImageHelper::base64ToAsset(
                $logo,
                sprintf('Logo %s', $clubName)
            ))->id
        ];
        return $club;
    }
}