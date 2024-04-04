@extends('layouts.default')

@section('title', 'Edit staff type')
@section('content')
    <div class="row">
        @foreach ($staffList as $staff)
            @php /**@var App\Models\StaffType $staff**/  @endphp
            <div class="col-sm">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">{{ $staff->name }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $staff->description }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm">
                                <a href="{{ route('staff-type.edit', $staff->id) }}"
                                   class="btn btn-primary btn-sm">Edit</a>
                            </div>
                            <div class="col-sm">
                                <form action="{{ route('staff-type.destroy', $staff->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
