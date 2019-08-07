@extends('layouts.app')

@section('content')
<div class="container justify-content-center content">
    <h3>Edit Data</h3>
    <div class="container-data-profile">
        Keyword:<p class="data-profile">{{ $keyword }}</p>
    </div>
    <button type="button" class="btn btn-default btn-update-profile" data-toggle="collapse" data-target="#demo">Edit</button>
    <div id="demo" class="collapse">
        <form action="/editsectionpost" method="POST" class="form-edit-profile">
            @csrf
            Keyword: <input class="form-control" type="text" name="keyword" value="{{ $keyword }}"><br>
            <input type="hidden" name="id_section" value="{{ $id }}">
            <input class="btn btn-default btn-update-profile" type="submit" name="save" value="Save">
        </form>
    </div>
</div>
@endsection