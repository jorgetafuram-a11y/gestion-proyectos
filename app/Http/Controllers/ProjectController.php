<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\User;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('students')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'required|in:en_curso,finalizado,archivado',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
        ]);
        Project::create($data);
        return redirect()->route('projects.index')->with('success','Proyecto creado');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'required|in:en_curso,finalizado,archivado',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
        ]);
        $project->update($data);
        return redirect()->route('projects.index')->with('success','Proyecto actualizado');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success','Proyecto eliminado');
    }

    // Formulario para asignar estudiantes
    public function assignForm(Project $project)
    {
        $students = Student::all();
        return view('projects.assign', compact('project','students'));
    }

    public function assignStudents(Request $request, Project $project)
    {
        // $request->students => array de student_id => role opcional
        $request->validate(['students'=>'array']);
        $sync = [];
        if($request->has('students')) {
            foreach($request->students as $id => $role) {
                $sync[$id] = ['role' => $role ?: 'miembro'];
            }
        }
        $project->students()->sync($sync); // reemplaza asignaciones; usar attach si quieres añadir
        return redirect()->route('projects.show', $project)->with('success','Estudiantes asignados');
    }
}
