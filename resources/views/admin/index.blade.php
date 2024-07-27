@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h1 class="text-center">Bienvenido {{ Auth::user()->name }}</h1>
</div>
<x-data-cards-component />
<x-search-latest-component :codigo="$codigo ?? null" />
@endsection