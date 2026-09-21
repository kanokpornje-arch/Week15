@extends('layouts.app')

@section('title', 'บทความ')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($blog2) > 0)

        <div class="d-flex justify-content-between align-items-center my-3">
            <h2 class="text-center">บทความทั้งหมด</h2>

            <a href="{{ route('author.create') }}" class="btn btn-success">
                + เขียนบทความใหม่
            </a>
        </div>

        <hr>

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Control</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($blog2 as $item)
                    <tr>
                        <td>{{ $item->title }}</td>

                        <td>
                            @if ($item->status)
                                <form method="POST" action="{{ route('author.status', $item) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">เผยแพร่</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('author.status', $item) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">ไม่เผยแพร่</button>
                                </form>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('author.edit', $item) }}" class="btn btn-warning">
                                แก้ไข
                            </a>

                            <form method="POST" action="{{ route('author.delete', $item) }}" class="d-inline" onsubmit="return confirm('คุณต้องการลบบทความนี้ {{ $item->title }} จริงหรือไม่?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $blog2->links() }}
    @else
        <div class="text-center my-5">
            <h2>ไม่มีบทความ</h2>

            <a href="{{ route('author.create') }}" class="btn btn-success mt-3">
                + เขียนบทความใหม่
            </a>
        </div>

    @endif

@endsection
