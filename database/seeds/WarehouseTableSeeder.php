<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warehouses')->insert([
            'name'     =>    'Compras Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que compra la empresa para usar en Visita Técnica vienen de este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Compras Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que compra la empresa para usar en Obras vienen de este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Compras Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que compra la empresa para usar en Garantías vienen de este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Cliente Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que se dejan/retiran en cliente de Visita Técnica van/vienen de este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Cliente Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que se dejan/retiran en actividades de Obra van/vienen de este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Cliente Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos que se dejan/retiran en actividades de Garantía van/vienen de este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Robados Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a VT que son robados van a este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Robados Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Obras que son robados van a este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Robados Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Garantías que son robados van a este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Perdidos Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a VT que son perdidos van a este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Perdidos Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Obras que son perdidos van a este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Perdidos Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados Garantías que son perdidos van a este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Dañados Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a VT que son Dañados van a este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Dañados Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Obras que son Dañados van a este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Dañados Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Garantías que son Dañados van a este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Telecentro para Visita Técnica',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a VT que entrega Telecentro vienen de este almacén',
            'activity_id'      =>    1,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Telecentro para Obras',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Obras que entrega Telecentro vienen de este almacén',
            'activity_id'      =>    2,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
        DB::table('warehouses')->insert([
            'name'     =>    'Telecentro para Garantías',
            'company_id'      =>    1,
            'description'      =>    'Los artículos destinados a Garantías que entrega Telecentro vienen de este almacén',
            'activity_id'      =>    3,
            'type_id'      =>    1,
            'active'    =>  1,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now(),
        ]);
    }
}
