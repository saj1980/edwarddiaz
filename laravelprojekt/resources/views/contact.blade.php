@extends('layouts.app')

@section('content')

    <h1>CONTACT page</h1>


    @if(count($people))

        @foreach($people as $person)

            <ul>

                <li>{{$person}}</li>


            </ul>



        @endforeach

    @endif

@endsection


@section('footer')

   {{--<script>alert('test');</script>--}}

    @endsection