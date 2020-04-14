@extends('layouts.form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="demo-bar" users='@json($data['users'])' user_id='@json($data['user_id'])' save_url="/api/form/add" edit_mode=0></div>
            <div id="react-form-builder" url="" saveUrl=""></div>
        </div>
    </div>
</div>
@endsection
