@extends('layouts.app')

@section('content')

    <h1>Edit post</h1>

    {!! Form::model($post, ['method' =>'PATCH', 'action'=> ['PostController@update', $post->id]]) !!}

    {{csrf_field()}}

    {!! Form::label('title', 'Title: ') !!}
    {!! Form::text('title', null, ['class'=>'form-control']) !!}


    {!! Form::submit('Update Post', ['class' => 'btn btn-primary']) !!}

    {!! Form::close () !!}


    <h1>Delete post</h1>


    {!! Form::open(['method'=>'DELETE', 'action'=>['PostController@destroy', $post->id]]) !!}

        {{csrf_field()}}

    {!! Form::submit('Delete Post', ['class' => 'btn btn-primary']) !!}

    {!! Form::close () !!}

