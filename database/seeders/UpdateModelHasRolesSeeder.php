<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('model_has_roles')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $modelClass = $row->model_type;
                $model = app($modelClass)::find($row->model_id);
                if ($model && $model->uuid) {
                    DB::table('model_has_roles')
                        ->where('role_id', $row->role_id)
                        ->where('model_type', $row->model_type)
                        ->where('model_id', $row->model_id)
                        ->update(['model_uuid' => $model->uuid]);
                }
            }
        });
    }
}
