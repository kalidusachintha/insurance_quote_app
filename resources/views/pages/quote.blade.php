@extends('layouts.app')
@section('title', 'Quotes')
@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <livewire:quote-form/>
        </div>

        <div class="lg:col-span-1">
            <x-banner/>
        </div>
    </div>
@endsection
