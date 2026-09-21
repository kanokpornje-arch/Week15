@extends('layouts.app')

@section('title', 'แก้ไขบทความ')

@section('content')
    <h2 class="text text-center by-2">แก้ไขบทความ</h2>
    <form method="POST" action="{{ route('author.update', $blog) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title" class="form-label">หัวข้อบทความ</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}">
        </div>
        @error('title')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <div class="form-group">
            <label for="content" class="form-label">เนื้อหาบทความ</label>
            <textarea class="form-control" id="content" name="content" cols="30" rows="10">{{ old('content', $blog->content) }}</textarea>
        </div>
        @error('content')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <div class="form-group">
            <label for="status" class="form-label">สถานะ</label>
            <select class="form-control" id="status" name="status">
                <option value="1" @selected(old('status', $blog->status) == 1)>เผยแพร่</option>
                <option value="0" @selected(old('status', $blog->status) == 0)>ไม่เผยแพร่</option>
            </select>
        </div>
        <br>
        <button type="submit" class="btn btn-success">บันทึก</button>
        <a href="{{ route('author.blog') }}" class="btn btn-success">บทความทั้งหมด</a>
    </form>
@endsection
