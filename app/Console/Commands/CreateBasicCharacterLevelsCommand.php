<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Services\LevelService;
use Illuminate\Console\Command;

class CreateBasicCharacterLevelsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'character:create-basic-levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the basic character levels';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $levelService = new LevelService();

        $levelsWithAscensions = $levelService->getCharacterLevelsWithAscensions();

        $characters = Character::query()
            ->doesntHave('characterLevels')
            ->orWhere(function ($query) {
                $query->has('characterLevels', '<', 16);
            })
            ->with('characterLevels')
            ->get();

        foreach ($characters as $character) {
            $character->characterLevels()->delete();

            $saveData = [];

            foreach ($levelsWithAscensions as $levelWithAscension) {
                $saveData[] = [
                    'character_id' => $character->id,
                    'level_id'     => $levelWithAscension['level_id'],
                    'ascension_id' => $levelWithAscension['ascension_id']
                ];
            }

            $character->characterLevels()->createMany($saveData);
        }


        return 0;
    }
}
