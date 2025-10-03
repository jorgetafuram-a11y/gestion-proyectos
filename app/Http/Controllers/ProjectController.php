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
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Project::class);
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
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);
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
        $this->authorize('delete', $project);
        $project->delete();
        return back()->with('success','Proyecto eliminado');
    }

    // Formulario para asignar estudiantes
    public function assignForm(Project $project)
    {
        $this->authorize('assign', $project);
        $students = Student::paginate(10);
        return view('projects.assign', compact('project','students'));
    }

    public function assignStudents(Request $request, Project $project)
    {
        $this->authorize('assign', $project);
        // $request->students => array de student_id => role opcional
        $request->validate([
            'students' => 'array',
            'students.*' => 'nullable|string|in:miembro,lider',
        ]);
        $sync = [];
        if($request->has('students')) {
            $ids = array_keys($request->students);
            // only consider existing student IDs
            $existing = Student::whereIn('id', $ids)->pluck('id')->all();
            foreach($request->students as $id => $role) {
                if(!in_array((int)$id, $existing)) continue;
                // use 'miembro' if role is empty or null
                $r = $role ?: 'miembro';
                // only sync valid students with allowed roles
                if(in_array($r, ['miembro','lider'])){
                    $sync[$id] = ['role' => $r];
                }
            }
        }
        $project->students()->sync($sync); // reemplaza asignaciones; usar attach si quieres añadir
        if($request->expectsJson()){
            return response()->json(['message' => 'Estudiantes asignados', 'data' => $sync], 200);
        }
        return redirect()->route('projects.show', $project)->with('success','Estudiantes asignados');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        $project->load('students');
        return view('projects.show', compact('project'));
    }

    public function unassignStudent(Project $project, Student $student)
    {
        $this->authorize('unassign', $project);
        $project->students()->detach($student->id);
        if(request()->expectsJson()){
            return response()->json(['message'=>'Estudiante desasignado','student_id'=>$student->id], 200);
        }
        return redirect()->route('projects.show', $project)->with('success','Estudiante desasignado');
    }
}
