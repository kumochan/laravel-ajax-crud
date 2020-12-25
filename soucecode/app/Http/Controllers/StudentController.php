<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
class StudentController extends Controller
{

    public function search(Request $request)
    {
        $students = DB::table('students')->where('first_name','like','%' .$request->txtSearch.'%')->get();
        return Response::json($students);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//
        $data['students'] = Student::orderBy('id','desc')->paginate(5);
        return view('student.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->txtFirstName);
		$student = new Student([
            'first_name' => $request->post('txtFirstName'),
            'last_name'=> $request->post('txtLastName'),
            'address'=> $request->post('txtAddress')
        ]);

		//dd($request->all());

		$student->save();    
        return Response::json($student);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
		return view('student.view',compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$where = array('id' => $id);
        $student  = Student::where($where)->first();
 
        return Response::json($student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
		$student = Student::find($request->id);
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->address = $request->address;
        $student->update();
		return Response::json($student);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$student = Student::where('id',$id)->delete();
        return Response::json($student);
    }
}
