@php /**@var App\Models\StaffType $staff**/  @endphp


@extends('layouts.default')
@section('title', 'New staff type')
@section('content')
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-8 col-lg-6">
            <!-- staff-type/edit.blade.php -->
            {{html()->form('POST', route('staff-type.store'))->open() }}

            @include('staff-type.partials.staff-form')

            {{ html()->submit('Update staff')->class('btn btn-primary') }}
            {{html()->closeModelForm()}}
        </div>
    </div>
@endsection
