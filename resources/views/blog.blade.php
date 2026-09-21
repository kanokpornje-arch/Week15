@extends('layouts.app')

@section('title', 'บทความ')

@section('content')
    <h2>บทความ</h2>
    <hr>
    @foreach ($blog as $item)
        <h2>{{ $item->title }}</h2>
        <p>{{ $item->content }}</p>
        <hr>
        @if ($item->status)
            <p class="text-success">สถานะ : เผยแพร่</p>
        @else
            <p class="text-danger">สถานะ : ไม่เผยแพร่</p>
        @endif
    @endforeach
@endsection
