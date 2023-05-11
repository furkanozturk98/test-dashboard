@extends('layouts.app')

@section('content')
    <test-run-dashboard :test-run-count="{{ (int)$testRunCount }}"></test-run-dashboard>
@endsection
