@extends('layouts.form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="forms-table" class="mt-3">
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th class="text-center">Has Form</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>

                            <td class="text-center">
                                @if ($user->formset)
                                <i class="fa fa-check" style="color: green"></i>
                                @else
                                <i class="fa fa-times" style="color: red"></i>
                                @endif
                            </td>
                            <td>
                                @if ($user->formset)
                                    <a class="btn btn-secondary btn-sm mr-1"
                                        href="{{ route('formset-view', $user->formset->uuid) }}"><i
                                            class="fa fa-edit"></i></a>
                                    <a class="btn btn-warning btn-sm"
                                        href="{{ route('formset-view', $user->formset->uuid) }}"><i
                                            class="fa fa-trash"></i></a>
                                @else
                                    <a class="btn btn-primary btn-sm mr-1"
                                        href="{{ route('formset-user-add', $user->id) }}"><i class="fa fa-plus"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after_script')
<script src="{{ asset('js/script.js') }}"></script>
@endsection