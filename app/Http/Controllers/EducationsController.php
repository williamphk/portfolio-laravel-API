<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EducationsController extends Controller
{
    public function addForm()
    {

        return view('educations.add');
    }

    public function add()
    {

        $attributes = request()->validate([
            'school' => 'required',
        ]);

        $type = new Education();
        $type->title = $attributes['school'];
        $type->save();

        return redirect('/console/educations/list')
            ->with('message', 'Education record has been added!');
    }
}
