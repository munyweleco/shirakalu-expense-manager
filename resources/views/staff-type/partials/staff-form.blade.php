@php /**@var App\Models\StaffType $staff**/  @endphp


<div class="form-group">
    {{html()->label('Staff name', 'name')->class('control-label')}}
    {{ html()->text('name')->class('form-control') }}
</div>

<div class="form-group">
    {{html()->label('Email', 'description')->class('control-label')}}
    {{ html()->textarea('description')->class('form-control')->rows(3) }}
</div>
