<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinuteController extends Controller
{
    public function show($id)
    {
        return "Show minute with ID: " . $id;
    }

    public function create()
    {
        return "Form create minute";
    }

    public function store(Request $request)
    {
        return "Store new minute";
    }

    public function edit($id)
    {
        return "Edit minute with ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Update minute with ID: " . $id;
    }
}
