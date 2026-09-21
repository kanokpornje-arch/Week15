<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;

class ClaimController extends Controller
{
    public function create()
    {
        return view('claim');
    }

    public function store(Request $request)
    {
        $request->validate([

            'serial_number' => 'required|min:6|max:20',

            'email' => 'required|email',

            'problem' => 'required|min:10',

            'priority' => 'required'

        ],[

            'serial_number.required' => 'กรุณากรอกรหัสสินค้า',

            'serial_number.min' => 'รหัสสินค้าต้องมีอย่างน้อย 6 ตัวอักษร',

            'serial_number.max' => 'รหัสสินค้าต้องไม่เกิน 20 ตัวอักษร',

            'email.required' => 'กรุณากรอกอีเมล',

            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',

            'problem.required' => 'กรุณาระบุอาการชำรุด',

            'problem.min' => 'รายละเอียดต้องไม่น้อยกว่า 10 ตัวอักษร',

            'priority.required' => 'กรุณาเลือกระดับความเร่งด่วน'

        ]);

        Claim::create($request->all());

        return redirect()->route('author.claim.create')
                ->with('success','ส่งข้อมูลแจ้งเคลมเรียบร้อย');
    }
}
