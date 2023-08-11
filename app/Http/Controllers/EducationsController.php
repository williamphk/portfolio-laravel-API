<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EducationsController extends Controller
{
    public function list()
    {
        return view('educations.list', [
            'educations' => Education::all()
        ]);
    }

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
        $education->user_id = Auth::user()->id;
        $education->save();

        return redirect('/console/educations/list')
            ->with('message', 'A new education record has been added!');
    }

    public function editForm(Education $education)
    {
        return view('educations.edit', [
            'education' => $education,
        ]);
    }

    public function edit(Education $education)
    {

        $attributes = request()->validate([
            'school' => 'required',
        ]);

        $education->school = $attributes['school'];
        $education->save();

        return redirect('/console/educations/list')
            ->with('message', 'Education record has been edited!');
    }

    public function delete(Education $education)
    {
        $education->delete();

        return redirect('/console/educations/list')
            ->with('message', 'Education record has been deleted!');
    }
}
