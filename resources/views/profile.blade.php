@extends('layouts.app')

@section('content')
<div class="page profile" style="background-image: url({{ asset('images/profile-bg.png') }})">
    <div class="content-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 align-self-center text-center">
                    <h3 class="ribbon-wrapper page-title text-truncate font-weight-medium mb-1 text-white">
                        <div class="ribbon">
                            <strong class="ribbon-inner">Profile</strong>
                        </div>
                    </h3>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-3">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-md-8 offset-auto">
                <div id="react-profile-form-first" data='@json($data)' action_url='{{ route('profile-update') }}'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_script')
@endsection