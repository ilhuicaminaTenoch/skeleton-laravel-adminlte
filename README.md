<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## INSTALAR PROYECTO
composer install<br>
npm install<br>

##CONFIGURACIONES

Modificar el siguiente archivo: <i>vendor/jeroennoten/laravel-adminlte/src/Events/BuildingMenu.php</i><br><br>
Esta modificacion se hace para poder implementar el menu de manera dinamica, es deicr; se puedeformar un menu con perfiles<br><br>
```
namespace JeroenNoten\LaravelAdminLte\Events;

use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Builder;

class BuildingMenu
{
    public $menu;
    public $auth;

    public function __construct(Builder $menu)
    {
        if (Auth::check()){
            $this->auth = Auth::user();
            $this->menu = $menu;
        }

    }
}
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
