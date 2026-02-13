@extends('layouts.app')
@section('title', $property->translated_title)
@section('meta_description', Str::limit($property->translated_description, 160))
@section('content')
    <livewire:property-detail :property="$property" />
@endsection
