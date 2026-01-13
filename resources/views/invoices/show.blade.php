@extends(backpack_view('blank'))
@php $invoice = $crud->entry @endphp
@section('content')
  <div class="mt-3">
      <h2>
      <span>{{ $crud->entity_name_plural }}</span>
      </h2>
  </div>

  <div class="row">
    <!-- <div class="col-12 my-3">
      <a href="{{ backpack_url('invoice/'.$invoice->id.'/edit') }}" class="btn btn-primary">
        <i class="fa fa-edit"></i> Editar
      </a>
    </div> -->

    <div class="col">
      @livewire('invoice.show', compact('invoice'))
    </div>

  </div>
@endsection
