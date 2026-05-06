@extends('agent.layout')

@section('title', $page['title'])
@section('page_title', $page['title'])
@section('page_subtitle', $page['subtitle'])

@section('content')
    @include('agent.modules.partials.module-page')
@endsection
