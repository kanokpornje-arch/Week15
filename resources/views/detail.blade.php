@extends('layouts.app')

@section('title', $blog->title)

@section('content')
    <h2>{{ $blog->title }}</h2>
    <hr>
    <!-- เปิดใช้การแสดงผลแบบ HTML แท้ใน Blade -->
    <div>{!! $blog->content !!}</div>
    <hr>
    <a href="{{ route('home') }}" class="btn btn-primary">กลับหน้าแรก</a>
@endsection
