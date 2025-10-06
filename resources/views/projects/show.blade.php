@extends('layouts.app')

@section('content')
  <h2>{{ $project->title }}</h2>
  <p>{{ $project->description }}</p>
  <p><strong>Estado:</strong> {{ $project->status }}</p>

  <h3>Estudiantes asignados</h3>
  <div id="unassign-feedback" class="mb-2" aria-live="polite"></div>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="toast-container"></div>
  </div>
  @if($project->students->isEmpty())
    <p>No hay estudiantes asignados.</p>
  @else
    <ul class="list-unstyled">
      @foreach($project->students as $s)
        <li id="assigned_{{ $s->id }}" class="mb-2 d-flex align-items-center">
          <div class="flex-grow-1">{{ $s->name }} - <em>{{ $s->pivot->role }}</em></div>
          <form class="unassign-form d-flex align-items-center" data-student-id="{{ $s->id }}" action="{{ route('projects.unassign', ['project'=>$project->id, 'student'=>$s->id]) }}" method="POST" onsubmit="return false;">
            @csrf
            <button class="btn btn-sm btn-danger btn-unassign">Desasignar</button>
            <div class="ms-2" id="spinner_{{ $s->id }}" style="display:none;"><div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div></div>
          </form>
        </li>
      @endforeach
    </ul>
  @endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  var feedback = document.getElementById('unassign-feedback');
  document.querySelectorAll('.unassign-form').forEach(function(f){
    f.addEventListener('click', function(e){
      if(!e.target.classList.contains('btn-unassign')) return;
      if(!confirm('Desasignar?')) return;
      var url = f.action;
      var studentId = f.dataset.studentId;
      var spinner = document.getElementById('spinner_'+studentId);
      if(spinner) spinner.style.display = '';
      if(feedback) feedback.innerHTML = '';

      fetch(url, {
        method: 'POST',
        headers: {
          'Accept':'application/json',
          'X-CSRF-TOKEN': f.querySelector('input[name="_token"]').value
        }
      }).then(function(r){
        if(spinner) spinner.style.display = 'none';
          if(r.ok){
            document.getElementById('assigned_'+studentId).remove();
            if(feedback) feedback.innerHTML = '<div class="visually-hidden">Estudiante desasignado</div>';
            showToast('success','Estudiante desasignado');
          } else {
            if(feedback) feedback.innerHTML = '<div class="visually-hidden">Error al desasignar</div>';
            showToast('danger','Error al desasignar');
          }
      }).catch(function(){ if(spinner) spinner.style.display = 'none'; if(feedback) feedback.innerHTML = '<div class="visually-hidden">Error de red</div>'; showToast('danger','Error de red'); });
    });
  });

  // showToast helper (same behavior as assign view)
  function showToast(type, message){
    try{
      var toastContainer = document.getElementById('toast-container');
      if(window.bootstrap && toastContainer){
        var toastEl = document.createElement('div');
        toastEl.className = 'toast align-items-center text-bg-'+(type==='success'?'success':'danger')+' border-0';
        toastEl.setAttribute('role','alert');
        toastEl.setAttribute('aria-live','assertive');
        toastEl.setAttribute('aria-atomic','true');
        toastEl.innerHTML = '<div class="d-flex"><div class="toast-body">'+message+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button></div>';
        toastContainer.appendChild(toastEl);
        var bToast = new bootstrap.Toast(toastEl, { delay: 3000 });
        bToast.show();
        toastEl.addEventListener('hidden.bs.toast', function(){ toastEl.remove(); });
        return;
      }
    }catch(e){ }
    var a = document.createElement('div');
    a.className = 'alert alert-'+(type==='success'?'success':'danger');
    a.setAttribute('role','alert');
    a.innerText = message;
    var feedback = document.getElementById('unassign-feedback');
    if(feedback) feedback.appendChild(a);
  }
});
</script>
@endpush

  <a href="{{ route('projects.index') }}">Volver</a>
  @auth
    @if(Auth::user()->is_admin)
      <form class="ajax-delete" action="{{ route('projects.destroy', $project) }}" method="POST" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger">Eliminar proyecto</button>
      </form>
    @endif
  @endauth
@endsection
