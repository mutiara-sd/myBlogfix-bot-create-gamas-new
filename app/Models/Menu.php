<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $with = ['roles'];

    public function subMenus(): HasMany
    {
        return $this->hasMany(Menu::class, 'menu_id')->with('subMenus');
    }

    public function subSubMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('subSubMenus');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_menus', 'menu_id', 'role_id');
    }
}
