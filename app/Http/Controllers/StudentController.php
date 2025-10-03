<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::paginate(20);
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show a simple create form for students. Only authenticated users can access this because route is protected.
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'program' => 'nullable|string|max:255',
        ]);

        $student = Student::create($request->only(['name','email','program']));

        return redirect()->route('students.show', $student)->with('success','Estudiante creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with('projects')->findOrFail($id);
        // only allow owner or admin to view detailed assignments
        if(!Auth::check() || (Auth::user()->student_id !== (int)$id && !Auth::user()->is_admin)){
            abort(403);
        }
        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
