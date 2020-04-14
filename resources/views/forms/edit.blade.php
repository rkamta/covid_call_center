@extends('layouts.form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="demo-bar" users='@json($data['users'])' user_id='@json($data['user_id'])'
                save_url="/api/form/update/{{ $data['formset_id'] }}" edit_mode=1></div>
            <div id="react-form-builder" url="/api/formdata/get/{{ $data['formset_id'] }}" saveUrl="/api/formdata/update/{{ $data['formset_id'] }}"></div>
        </div>
    </div>
</div>
@endsection