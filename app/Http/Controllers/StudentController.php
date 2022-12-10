<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class StudentController extends Controller
{

    public function index()
    {
    }

    public function store(Request $request)
    {
        $data = new Student();
        $data->name = $request->name;
        return $data->save();
    }


    public function getAllData()
    {
        $result = DB::table('students')->get();
        return $result;
    }

    public function view($id)
    {
    }
    public function edit($id)
    {
        return Student::find($id);
    }


    public function update(Request $request, $id)
    {
        $result = Student::find($request->id);
        $result->name = $request->name;
        $result->save();
        return $result;
    }
    public function destroy($id)
    {
        $result = Student::find($id);
        $result->delete();
    }
}