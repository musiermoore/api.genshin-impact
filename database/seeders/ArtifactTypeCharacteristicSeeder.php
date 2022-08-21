<?php

namespace Database\Seeders;

use App\Models\ArtifactType;
use App\Models\Characteristic;
use Illuminate\Database\Seeder;

class ArtifactTypeCharacteristicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artifactTypes = ArtifactType::query()
            ->get()
            ->keyBy('slug');

        $characteristicIds = Characteristic::query()
            ->whereIn('slug', [
                'hp'
            ])
            ->pluck('id')
            ->toArray();

        $artifactTypes[ArtifactType::FLOWER_OF_LIFE]->mainCharacteristics()->sync($characteristicIds);

        $characteristicIds = Characteristic::query()
            ->whereIn('slug', [
                'atk'
            ])
            ->pluck('id')
            ->toArray();

        $artifactTypes[ArtifactType::PLUME_OF_DEATH]->mainCharacteristics()->sync($characteristicIds);

        $characteristicIds = Characteristic::query()
            ->whereIn('slug', [
                'hp-percent',
                'atk-percent',
                'def-percent',
                'elemental-mastery',
                'energy-recharge'
            ])
            ->pluck('id')
            ->toArray();

        $artifactTypes[ArtifactType::SANDS_OF_EON]->mainCharacteristics()->sync($characteristicIds);

        $characteristicIds = Characteristic::query()
            ->whereIn('slug', [
                'hp-percent',
                'atk-percent',
                'def-percent',
                'elemental-mastery',
                'pyro-dmg-bonus',
                'electro-dmg-bonus',
                'cryo-dmg-bonus',
                'hydro-dmg-bonus',
                'anemo-dmg-bonus',
                'geo-dmg-bonus',
                'dendro-dmg-bonus',
                'physical-dmg-bonus'
            ])
            ->pluck('id')
            ->toArray();

        $artifactTypes[ArtifactType::GOBLET_OF_EONOTHEM]->mainCharacteristics()->sync($characteristicIds);

        $characteristicIds = Characteristic::query()
            ->whereIn('slug', [
                'hp-percent',
                'atk-percent',
                'def-percent',
                'elemental-mastery',
                'crit-rate',
                'crit-dmg',
                'healing-bonus'
            ])
            ->pluck('id')
            ->toArray();

        $artifactTypes[ArtifactType::CIRCLET_OF_LOGOS]->mainCharacteristics()->sync($characteristicIds);
    }
}

