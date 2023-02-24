<?php
declare(strict_types=1);

namespace modules\sitemodule\helpers;

use Craft;
use craft\elements\Asset;

class ImageHelper {
    public static function base64ToAsset(string $base64, string $name): Asset
    {
        $tmpPath = Craft::$app->getPath()->getTempPath();
        file_put_contents(
            sprintf('%s/temp.png', $tmpPath),
            base64_decode($base64)
        );

        // create a new asset
        $asset = new Asset();
        $asset->tempFilePath = sprintf('%s/temp.png', $tmpPath);
        $asset->filename = sprintf('%s.png', $name);
        $asset->title = $name;
        $asset->kind = "Image";
        $asset->avoidFilenameConflicts = false;
        $asset->setScenario(Asset::SCENARIO_CREATE);

        $volume = Craft::$app->getVolumes()->getVolumeByHandle('public');
        $folder = Craft::$app->assets->getFolderById(8);

        $asset->folderId = 0;
        $asset->newFolderId = $folder->id;
        $asset->newFilename = sprintf('%s.png', $name);
        $asset->volumeId = $volume->id;

        // save the asset
        $success = Craft::$app->getElements()->saveElement($asset);
        if (!$success) {
            dd($asset->getErrors());
            // respond with errors ($asset->getErrors())
        }

        return $asset;
    }
}