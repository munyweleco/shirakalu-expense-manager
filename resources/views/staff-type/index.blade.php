@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card border-primary">
            <div class="card-header border-primary">Manage Staff Type</div>
            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered']) !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
