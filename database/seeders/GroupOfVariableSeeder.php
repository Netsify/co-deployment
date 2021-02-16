<?php

namespace Database\Seeders;

use App\Models\Facilities\FacilityType;
use App\Models\Variables\Group;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupOfVariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            foreach ($this->groups() as $group) {
                $g = new Group(['slug' => $group['slug']]);

                if ($g->save()) {
                    $g->facilityTypes()->attach($group['types']);
                }
            }
            DB::commit();
        } catch (\PDOException $e) {
            echo "error: " . $e->getMessage();
            DB::rollBack();
        }
    }

    protected function groups()
    {
        $types = FacilityType::all();
        $road = $types->where('slug', 'road')->first();
        $railway = $types->where('slug', 'railway')->first();
        $electricity = $types->where('slug', 'electricity')->first();
        $ict = $types->where('slug', 'ict')->first();
        $other = $types->where('slug', 'other')->first();

        $groups = [
            ['slug' => "var_{$road->slug}", 'types' => $road->id],
            ['slug' => "var_{$railway->slug}", 'types' => $railway->id],
            ['slug' => "var_{$electricity->slug}", 'types' => $electricity->id],
            ['slug' => "var_{$other->slug}", 'types' => $other->id],
            ['slug' => "var_{$ict->slug}", 'types' => $ict->id],

            ['slug' => "var_{$ict->slug}_{$road->slug}", 'types' => [$ict->id, $road->id]],
            ['slug' => "var_{$ict->slug}_{$railway->slug}", 'types' => [$ict->id, $railway->id]],
            ['slug' => "var_{$ict->slug}_{$electricity->slug}", 'types' => [$ict->id, $electricity->id]],
            ['slug' => "var_{$ict->slug}_{$other->slug}", 'types' => [$ict->id, $other->id]],
        ];

        return $groups;
    }
}
