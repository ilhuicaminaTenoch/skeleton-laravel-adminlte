<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $idRol = $event->auth->id_rol;
            if ($idRol == 1) {
                $event->menu->add('ADMINISTRADOR');
                $event->menu->add([
                    'text' => 'Accesos',
                    'icon' => 'fas fa-fw fa-universal-access',
                    'submenu' => [
                        [
                            'text' => 'Usuarios',
                            'icon' => 'fas fa-fw fa-user-tie',
                            'url' => '/user',
                        ],
                        [
                            'text' => 'Roles',
                            'icon' => 'fas fa-fw fa-portrait',
                            'url' => '/rol',
                        ],
                    ],
                ]);
                $event->menu->add([
                    'text' => 'CATEGORIAS',
                    'icon' => 'fas fa-fw fa-clipboard-list',
                    'submenu' => [
                        [
                            'text' => 'Telenovelas',
                            'icon' => 'fas fa-couch',
                            'url' => '/listado-categorias',
                        ],
                        [
                            'text' => 'Programas de tv',
                            'icon' => 'fas fa-tv',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Comedia',
                            'icon' => 'fas fa-theater-masks',
                            'url' => '#'
                        ],
                        [
                            'text' => 'Realities',
                            'icon' => 'fas fa-vr-cardboard',
                            'url' => '#'
                        ],

                    ]
                ]);
            }elseif ($idRol == 2){
                $event->menu->add('EDITOR');
                $event->menu->add([
                    'text' => 'Acceso',
                    'icon' => 'fas fa-fw fa-universal-access',
                    'submenu' => [
                        [
                            'text' => 'Usuarios',
                            'icon' => 'fas fa-fw fa-user-tie',
                            'url' => '#',
                        ],

                    ]
                ]);
            }
        });
    }
}
