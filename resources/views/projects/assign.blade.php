@extends('layouts.app')
@section('content')
<h2>Asignar estudiantes a: {{ $project->title }}</h2>

<form action="{{ route('projects.assign', $project) }}" method="POST">
  @csrf
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Seleccionar</th>
          <th>Nombre</th>
          <th>Role</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $s)
          @php
            $assigned = $project->students->contains($s->id);
            $role = $assigned ? $project->students->find($s->id)->pivot->role : '';
          @endphp
          <tr>
            <td class="align-middle">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="s{{ $s->id }}" {{ $assigned ? 'checked' : '' }} onclick="toggleRole({{ $s->id }}, this.checked)">
                <label class="form-check-label" for="s{{ $s->id }}"></label>
              </div>
              <input type="hidden" name="students[{{ $s->id }}]" id="students_role_{{ $s->id }}" value="{{ $role }}">
            </td>
            <td class="align-middle">{{ $s->name }} <br><small class="text-muted">{{ $s->email }}</small></td>
            <td>
              <input type="text" class="form-control" id="input_role_{{ $s->id }}" value="{{ $role }}" placeholder="lider/miembro" oninput="document.getElementById('students_role_{{ $s->id }}').value = this.value" {{ $assigned ? '' : 'disabled' }}>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-3 d-flex align-items-center">
    <button class="btn btn-primary" id="assign-submit">Guardar asignaciones</button>
    <a href="{{ route('projects.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    <div id="assign-spinner" class="ms-3" style="display:none;" aria-hidden="true">
      <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>
      <span class="visually-hidden">Cargando...</span>
    </div>
  </div>
</form>

<div class="mt-3">
  {{ $students->links() }}
</div>

  <div id="assign-feedback" class="mt-3" aria-live="polite"></div>

  <!-- Toast container -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
    <div id="toast-container"></div>
  </div>

@push('scripts')
<script>
function toggleRole(id, checked){
  var input = document.getElementById('input_role_'+id);
  var hidden = document.getElementById('students_role_'+id);
  if(checked){
    input.removeAttribute('disabled');
    if(!hidden.value) hidden.value = 'miembro';
    input.value = hidden.value;
  } else {
    input.setAttribute('disabled','disabled');
    hidden.value = '';
    input.value = '';
  }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var form = document.querySelector('form[action="{{ route('projects.assign', $project) }}"]');
  if(!form) return;
  form.addEventListener('submit', function(e){
    // if user holds SHIFT (or ctrl) we allow normal submit
    if(e.shiftKey) return;
    e.preventDefault();
    var students = {};
    document.querySelectorAll('input[type="hidden"][id^="students_role_"]').forEach(function(h){
      var id = h.id.replace('students_role_','');
      var val = h.value || '';
      if(val) students[id] = val;
    });

  var spinner = document.getElementById('assign-spinner');
  var feedback = document.getElementById('assign-feedback');
  var toastContainer = document.getElementById('toast-container');
    if(spinner) spinner.style.display = '';
    if(feedback) feedback.innerHTML = '';

    fetch(form.action, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: JSON.stringify({students: students})
    }).then(function(r){
      return r.json().then(function(json){
        if(spinner) spinner.style.display = 'none';
        if(r.ok){
          showToast('success', json.message || 'Asignado');
          feedback.innerHTML = '<div class="visually-hidden">'+(json.message||'Asignado')+'</div>';
        } else {
          showToast('danger', json.message || 'Error');
          feedback.innerHTML = '<div class="visually-hidden">'+(json.message||'Error')+'</div>';
        }
      });
    }).catch(function(){
      if(spinner) spinner.style.display = 'none';
      if(feedback) feedback.innerHTML = '<div class="visually-hidden">Error de red</div>';
      showToast('danger','Error de red');
    });
  });
  
  // helper to show toast if Bootstrap available, otherwise fallback to simple alert markup
  function showToast(type, message){
    try{
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
        // remove after hidden
        toastEl.addEventListener('hidden.bs.toast', function(){ toastEl.remove(); });
        return;
      }
    }catch(e){ }
    // fallback: append simple alert
    var a = document.createElement('div');
    a.className = 'alert alert-'+(type==='success'?'success':'danger');
    a.setAttribute('role','alert');
    a.innerText = message;
    feedback.appendChild(a);
  }
});
</script>
@endpush
@endsection
