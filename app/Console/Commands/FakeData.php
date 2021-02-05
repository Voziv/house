<?php

namespace App\Console\Commands;

use App\Models\ConditionReading;
use App\Models\Sensor;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:fake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a bunch of fake data for some all available rooms';

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
    public function handle(Generator $faker)
    {
        /** @var Sensor[] $sensors */
        $sensors = Sensor::with('room')->get();

        $now = new Carbon();
        $oneMonthAgo = new Carbon('-6 months');
        $period = $oneMonthAgo->minutesUntil(new Carbon())->toArray();

        $totalIterations = count($period) * count($sensors);
        $bar = $this->output->createProgressBar($totalIterations);

        foreach ($sensors as $sensor) {
            $conditionReadings = [];

            $room_id = ($sensor->has('room')) ? $sensor->room->id : null;

            $saveBatchSize = 500;
            foreach ($period as $created_at) {
                $conditionReadings[] = [
                    'created_at' => $created_at,
                    'updated_at' => $created_at,
                    'sensor_id' => $sensor->id,
                    'room_id' => $room_id,
                    'temperature' => $faker->numberBetween(10, 20),
                    'humidity' => $faker->numberBetween(30, 60),
                ];

                if (count($conditionReadings) >= $saveBatchSize) {
                    ConditionReading::insert($conditionReadings);
                    $bar->advance(count($conditionReadings));
                    $conditionReadings = [];
                }
            }

            if (count($conditionReadings) > 0) {
                ConditionReading::insert($conditionReadings);
                $bar->advance(count($conditionReadings));
            }
        }

        // Success!
        return 0;
    }
}
