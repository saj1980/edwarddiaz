@extends('layouts.app')

@section('content')

    <h1>Create post</h1>

    {{--<form method="post" action="http://localhost:8888/laravelprojekt/public/posts">--}}

    {!! Form::open(['method' =>'POST', 'action'=> 'PostController@store']) !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">


        {!! Form::label('title', 'Title: ') !!}
        {!! Form::text('title', null, ['class'=>'form-control']) !!}


    </div>

    <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! Form::submit('Create Post', ['class' => 'btn btn-primary']) !!}


        {!! Form::close() !!}

    </div>

{{ var_dump($errors) }}




    @if($errors->any())
        <ul class="alert alert-danger">


            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


@endsection