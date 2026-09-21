@extends('layouts.app')

@section('title', 'แจ้งเคลมสินค้าชำรุด')

@section('content')

    <div class="container mt-4">

        <h2 class="text-center text-danger mb-4">
            🛠 ฟอร์มแจ้งเคลมสินค้าชำรุด
        </h2>

        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif

        <form action="{{ route('author.claim.store') }}" method="POST">

            @csrf

            <!-- Serial Number -->

            <div class="mb-3">

                <label class="form-label">

                    รหัสสินค้า (Serial Number)

                </label>

                <input type="text" name="serial_number" class="form-control @error('serial_number') is-invalid @enderror"
                    value="{{ old('serial_number') }}" placeholder="เช่น SN123456">

                @error('serial_number')
                    <div class="text-danger">

                        {{ $message }}

                    </div>
                @enderror

            </div>

            <!-- Email -->

            <div class="mb-3">

                <label class="form-label">

                    อีเมลผู้ติดต่อ

                </label>

                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="example@email.com">

                @error('email')
                    <div class="text-danger">

                        {{ $message }}

                    </div>
                @enderror

            </div>

            <!-- Problem -->

            <div class="mb-3">

                <label class="form-label">

                    อาการชำรุด

                </label>

                <textarea name="problem" rows="5" class="form-control @error('problem') is-invalid @enderror"
                    placeholder="อธิบายอาการชำรุด">{{ old('problem') }}</textarea>

                @error('problem')
                    <div class="text-danger">

                        {{ $message }}

                    </div>
                @enderror

            </div>

            <!-- Priority -->

            <div class="mb-3">

                <label class="form-label">

                    ระดับความเร่งด่วน

                </label>

                <select name="priority" class="form-select @error('priority') is-invalid @enderror">

                    <option value="">-- เลือก --</option>

                    <option value="ต่ำ" {{ old('priority') == 'ต่ำ' ? 'selected' : '' }}>

                        ต่ำ

                    </option>

                    <option value="ปานกลาง" {{ old('priority') == 'ปานกลาง' ? 'selected' : '' }}>

                        ปานกลาง

                    </option>

                    <option value="สูง" {{ old('priority') == 'สูง' ? 'selected' : '' }}>

                        สูง

                    </option>

                </select>

                @error('priority')
                    <div class="text-danger">

                        {{ $message }}

                    </div>
                @enderror

            </div>

            <button type="submit" class="btn btn-danger">

                📤 ส่งข้อมูลเคลม

            </button>

        </form>

    </div>

@endsection
