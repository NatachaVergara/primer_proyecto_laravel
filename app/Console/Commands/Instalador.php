<?php

namespace App\Console\Commands;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando ejecuta el instalador inicial del proyecto';

    /**
     * Execute the console command.
     *
     * @return int
     */

   

    public function handle()
    {
        if(!$this->verificar()){           
            $rol = $this->crearRolSuperAdmin();
            $usuario = $this->crearUsuarioSuperAdmin();
            $usuario->roles()->attach($rol);
            $this->line('El Rol y Usuario Administrador se instalaron correctamente');
        }else{
            $this->error('No se puede ejecutar el instalador!');
        }

       
    }

    private function verificar(){
        //Permite que no se repita el rol 1
       return Rol::find(1);
       
    }


  

    private function crearRolSuperAdmin(){
        $rol = "Super administrator";
        return Rol::create([
            'nombre' => $rol,
            'slug' => Str::slug($rol, '_'),

        ]);
    }

  
    private function crearUsuarioSuperAdmin(){
        return Usuario::create([
            'nombre' => 'tuto_admin',
            'email' => 'ntchvergara@gmail.com',
            'password' => Hash::make('pass1234'),
            'estado' => 1
        ]);
    }
}