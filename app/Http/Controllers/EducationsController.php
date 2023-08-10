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

        $education = new Education();
        $education->school = $attributes['school'];
        $education->save();

        return redirect('/console/educations/list')
            ->with('message', 'A new education record has been added!');
    }

    public function delete(Education $education)
    {
        $education->delete();
        
        return redirect('/console/educations/list')
            ->with('message', 'Education record has been deleted!');        
    }
}
