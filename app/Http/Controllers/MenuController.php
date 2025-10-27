<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|in:menu,submenu',
            'name' => 'required|max:255|unique:menus',
            'menu_id' => 'nullable|exists:menus,id',
            'parent_id' => 'nullable|exists:menus,id',
            'route' => 'required|max:255',
            'icon' => 'nullable|max:255',
            'list' => 'nullable',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $menu = Menu::create([
            'name' => $validatedData['name'],
            'route' => $validatedData['route'],
            'icon' => $validatedData['icon'] ?? null,
            'list' => $validatedData['list'] ?? null,
            'menu_id' => $validatedData['menu_id'] ?? null,
            'parent_id' => $validatedData['parent_id'] ?? null,
        ]);

        if (! empty($validatedData['roles'])) {
            $menu->roles()->sync($validatedData['roles']);
        }

        return redirect()->back()->with('success', 'New Menu has been created!');
    }

    public function update(Request $request)
    {
        $menu = Menu::findOrFail($request->id);

        $validatedData = $request->validate([
            'type' => 'required|in:menu,submenu',
            'id' => 'required|exists:menus,id',
            'name' => 'required|max:255|unique:menus,name,'.$menu->id,
            'menu_id' => 'nullable|exists:menus,id',
            'parent_id' => 'nullable|exists:menus,id',
            'route' => 'required|max:255',
            'icon' => 'nullable|max:255',
            'list' => 'nullable',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $menu->update([
            'name' => $validatedData['name'],
            'route' => $validatedData['route'],
            'icon' => $validatedData['icon'] ?? null,
            'list' => $validatedData['list'] ?? null,
            'menu_id' => $validatedData['menu_id'] ?? null,
            'parent_id' => $validatedData['parent_id'] ?? null,
        ]);

        if (isset($validatedData['roles'])) {
            $menu->roles()->sync($validatedData['roles']);
        } else {
            $menu->roles()->detach();
        }

        return redirect()->back()->with('success', 'Menu updated successfully!');
    }

    public function destroy(Request $request)
    {
        $menuId = $request->input('menu');

        if (! $menuId) {
            return redirect()->back()->with('error', 'Please Select a Menu You Want to Delete.');
        }

        $menu = Menu::find($menuId);

        if (! $menu) {
            return redirect()->back()->with('error', 'Menu not Found.');
        }

        $menu->roles()->detach();
        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted successfully!');
    }
}
