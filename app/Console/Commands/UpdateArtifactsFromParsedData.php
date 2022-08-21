<?php

namespace App\Console\Commands;

use App\Http\Traits\ImageUpload;
use App\Models\ArtifactSet;
use App\Models\ArtifactType;
use App\Models\ImageType;
use App\Models\Rarity;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateArtifactsFromParsedData extends Command
{
    use ImageUpload;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-data:artifacts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =
        'Update artifact sets and their artifacts by parsed data by a python app. ' .
        'To get files (images/json) need to set variable in the .env file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $slash = '/';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $pathToParsedData = config('app.path_to_parsed_data');

        if (empty($pathToParsedData)) {
            Log::error('Config is missing: path_to_parsed_data');
            $this->line('Config is missing: path_to_parsed_data');
            return 0;
        }

        if (str_contains($pathToParsedData, ':\\')) {
            $this->slash = '\\';
        }

        $pathToJsonFolder = $this->concatPaths([$pathToParsedData, 'exports', 'json']);

        $path = realpath($this->concatPaths([$pathToJsonFolder, 'artifacts', 'artifacts.json']));

        if (!$path) {
            Log::error('UpdateArtifactsFromParsedData: open file error');
            $this->line('open file error: ' . $path);
            return;
        }

        $jsonString = file_get_contents($path);

        if (!$jsonString) {
            Log::error('UpdateArtifactsFromParsedData: open json file error');
            $this->line('open json file error');
            return;
        }

        try {
            $artifactSets = json_decode(iconv(mb_detect_encoding($jsonString), "UTF-8", $jsonString), true);
        } catch (\Exception $exception) {
            Log::error('UpdateArtifactsFromParsedData: convert to utf-8 error');
            $this->line('convert to utf-8 error');
            return;
        }

        foreach ($artifactSets as $artifactSet) {
            if (empty($artifactSet['slug'])) {
                continue;
            }

            $pathToArtifactImages = $this->concatPaths([$pathToParsedData, 'images', 'artifacts']);
            $pathToArtifactSet = $this->concatPaths([$pathToArtifactImages, $artifactSet['slug']]);

            $artifactSetModel = $this->createArtifactSet($artifactSet);
            $this->setRaritiesToArtifactSet($artifactSetModel, $artifactSet['rarities']);

            if (!empty($artifactSet['artifacts'])) {
                $this->createArtifacts($artifactSetModel, $artifactSet['artifacts'], $pathToArtifactSet);
            }
        }


    }

    private function createArtifactSet($artifactSet)
    {
        return ArtifactSet::query()
            ->updateOrCreate([
                'slug' => $artifactSet['slug']
            ],
            [
                'name' => $artifactSet['name'],
                'slug' => $artifactSet['slug']
            ]);
    }

    private function setRaritiesToArtifactSet($artifactSet, $artifactSetRarities)
    {
        $rarityIds = Rarity::query()
            ->whereIn('rarity', $artifactSetRarities)
            ->pluck('id')
            ->toArray();

        $artifactSet->rarities()->sync($rarityIds);
    }

    private function createArtifacts($artifactSet, $artifacts, $pathToArtifactSet = null)
    {
        foreach ($artifacts as $artifact) {
            if (empty($artifact['slug'])) {
                continue;
            }

            $artifact = $this->createArtifact($artifactSet, $artifact);

            $pathToArtifactSet = realpath($pathToArtifactSet);
            if ($pathToArtifactSet) {
                $imageType = ImageType::query()
                    ->where('slug', ImageType::MAIN)
                    ->first();

                $publicPath = storage_path($this->concatPaths([
                    'app', 'public', 'images', 'artifacts', $artifactSet['slug']
                ]));

                if (!file_exists($publicPath)) {
                    mkdir($publicPath, 0777, true);
                }

                $copyStatus = copy(
                    $this->concatPaths([$pathToArtifactSet, $artifact['slug'] . '.png']),
                    $this->concatPaths([$publicPath, $artifact['slug'] . '.png'])
                );

                if ($copyStatus) {
                    $artifact->image()->updateOrCreate([
                        'imageable_id' => $artifact['id']
                    ], [
                        'path' => 'images/' . $artifactSet['slug'] . '/' . $artifact['slug'] . '.png',
                        'image_type_id' => $imageType['id']
                    ]);
                }
            }
        }
    }

    private function createArtifact($artifactSet, $artifact)
    {
        $artifactTypeId = ArtifactType::getArtifactTypeIdBySlug($artifact['type']);

        return $artifactSet->artifacts()
            ->updateOrCreate([
                'slug' => $artifact['slug']
            ],
            [
                'artifact_type_id' => $artifactTypeId,
                'name'             => $artifact['name'],
                'slug'             => $artifact['slug']
            ]);
    }

    private function concatPaths($array)
    {
        return implode($this->slash, $array);
    }
}
