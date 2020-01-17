<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;


class MenuFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        // TODO: Implement transform() method.
        if (isset($item['permission']) && ! Laratr::can($item['permission'])) {
            return false;
        }

        return $item;
    }

}
