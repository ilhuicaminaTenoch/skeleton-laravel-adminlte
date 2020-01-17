<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['id' => 1, 'nombre' => 'Administrator', 'descripcion' => 'Administradores de área', 'activo' => '1'],
            ['id' => 2, 'nombre' => 'Editor', 'descripcion' => 'Editor de contenido multimedia', 'activo' => '1'],
        ];

        foreach ($items as $item) {
            \App\Roles::updateOrCreate(['id' => $item['id']], $item);
        }
    }
}
