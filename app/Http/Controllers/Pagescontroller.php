<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Intervention\Image\Facades\image;

class PagesController extends Controller
{
    public function home() {
        $data = [
            'name'=>'Tatsam',
            'age'=>18
        ];
        return view('welcome')->with($data);
    }

    public function profile(){
        $data1=[
            'username'=>'Tatsam'
        ];
        return view('profile')->with($data1);
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        $student= new Student();
        $student->name =$request->name;
        $student->address =$request->address;
        $student->age =$request->age;
        $student->dob =$request->dob;

        $filenameWithEx=$request->file('image')->getClientOriginalName();
        $img=Image::make($request->file('image'));
        $filename =$request->file('image')->getClientOriginalName();
        $img->save('storage/image/'.$filename);
        $student->save();
        return 'Saved';

    }
    public function list(){
        $students=Student::orderby('name','asc')->get();
        return view('list')->with('students',$students);
    }
    public function edit($id) {
        $student = Student::where('id',$id)->first();
        return view('update')->with('student',$student);
//        $student = Student::find($id);
    }

    public function update(Request $request) {
        $student = Student::where('id',$request->id)->first();
        $student->name = $request->name;
        $student->address = $request->address;
        $student->age = $request->age;
        $student->save();
        return redirect('/list');
    }

}
