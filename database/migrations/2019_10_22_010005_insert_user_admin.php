<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class InsertUserAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sectors')->insert([
            'name_sector' => 'Manutenção',
            'created_at' => now()
        ]);
        DB::table('sectors')->insert([

            'name_sector' => 'Governança',
            'created_at' => now()
        ]);
        DB::table('sectors')->insert([
            'name_sector' => 'Financeiro',
            'created_at' => now()
        ]);
        DB::table('sectors')->insert([
            'name_sector' => 'Marketing',
            'created_at' => now()
        ]);
        DB::table('sectors')->insert([
            'name_sector' => 'Outros',
            'created_at' => now()
        ]);
        DB::table('sector_providers')->insert([
            'name_sector' => 'Governança',
            'created_at' => now()
        ]);
        DB::table('sector_providers')->insert([
            'name_sector' => 'Manutenção',
            'created_at' => now()
        ]);
        $username = env('ADMIN_USERNAME', 'admin');
        $password = bcrypt(env('ADMIN_PASSWORD', 'osfacildemais'));
        DB::table('users')->insert([
            'first_name' => 'Administrador',
            'last_name' => 'Sistema',
            'document' => '12365478910',
            'email' => 'admin@osfacil.com',
            'username' => $username,
            'password' => $password,
            'function' => 4,
            'sector' => 1,
            'primary_contact' => '(45) 99871-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Matielo',
            'last_name' => 'Supervisor',
            'document' => '00817900900',
            'email' => 'matielo@gmail.com',
            'username' => 'matielo',
            'password' => bcrypt(env('1234')),
            'function' => 3,
            'sector' => 1,
            'primary_contact' => '(45) 99876-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Andrew',
            'last_name' => 'Supervisor',
            'document' => '01817900900',
            'email' => 'andrew@gmail.com',
            'username' => 'andrew',
            'password' => bcrypt(env('1234')),
            'function' => 3,
            'sector' => 1,
            'primary_contact' => '(45) 99276-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Mario',
            'last_name' => 'Técnico',
            'document' => '98745632100',
            'email' => 'tecnico@osfacil.com',
            'username' => 'tecnico',
            'password' => bcrypt(env('1234')),
            'function' => 2,
            'sector' => 1,
            'primary_contact' => '(45) 99777-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'Mario1',
            'last_name' => 'Técnico',
            'document' => '68745632100',
            'email' => 'tecnico1@osfacil.com',
            'username' => 'tecnico1',
            'password' => bcrypt(env('1234')),
            'function' => 2,
            'sector' => 1,
            'primary_contact' => '(45) 99847-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'João',
            'last_name' => 'Funcionario',
            'document' => '45612378900',
            'email' => 'joao@osfacil.com',
            'username' => 'funcionario',
            'password' => bcrypt(env('1234')),
            'function' => 1,
            'sector' => 1,
            'primary_contact' => '(45) 99867-5463',
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'first_name' => 'João1',
            'last_name' => 'Funcionario',
            'document' => '75612378900',
            'email' => 'joao2@osfacil.com',
            'username' => 'funcionario1',
            'password' => bcrypt(env('1234')),
            'function' => 1,
            'sector' => 1,
            'primary_contact' => '(45) 99877-5463',
            'created_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $username = env('ADMIN_USERNAME', 'admin');
        $sector = env('ADMIN_SECTOR'); //"Outros";
        DB::delete('DELETE FROM users WHERE username = ?', [$username]);
        DB::delete('DELETE FROM sectors WHERE name_sector = ?', [$sector]);
    }
}
