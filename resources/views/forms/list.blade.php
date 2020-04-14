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
                            <th>Province</th>
                            <th class="text-center">Has Form</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->profile }}</td>

                            <td class="text-center">
                                @if ($user->formset)
                                <i class="fa fa-check" style="color: green"></i>
                                @else
                                <i class="fa fa-times" style="color: red"></i>
                                @endif
                            </td>
                            <td>
                                @if ($user->formset)
                                <input type="checkbox" name="active" id="active">
                                @else
                                <i class="fa fa-ban text-muted"></i>
                                @endif
                            </td>
                            <td>
                                @if ($user->formset)
                                <a class="btn btn-secondary btn-sm mr-1"
                                    href="{{ route('formset-edit', $user->formset->id) }}"><i
                                        class="fa fa-edit"></i></a>
                                <button class="btn btn-warning btn-sm"
                                    onclick="delFormSet('{{ route('formset-delete', $user->formset->uuid) }}')"><i
                                        class="fa fa-trash"></i></button>
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
<script>
    function delFormSet(url) {
        if(confirm('Sure?')) {
            window.location.href = url;
        }
    }
</script>
@endsection