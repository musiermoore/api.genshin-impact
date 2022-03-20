<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RunBasicSeeds extends Seeder
{
    /**
     * Run the basic seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AscensionSeed::class,
            CharacteristicTypeSeed::class,
            ElementSeed::class,
            LevelSeed::class,
            ServerSeed::class,
            SkillTypeSeed::class,
            StarSeed::class,
            WeaponTypeSeed::class,
            ArtifactTypeSeed::class
        ]);
    }
}
