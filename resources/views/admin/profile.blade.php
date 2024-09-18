@extends('admin.app')
@section('title','Admin User | Profile') 
@section('heading','Profile') 

@section('main_content')
    <h1>{{ $profile->name }}</h1>
@endsection