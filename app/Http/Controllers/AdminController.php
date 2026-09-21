<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function about2()
    {
        $name = 'Kanokporn Jeamthong';
        $date = '5 กรกฎาคม 2026';

        return view('about2', compact('name', 'date'));
    }

    public function blog2()
    {
        $blog2 = Blog::latest()->paginate(10);

        return view('blog2', compact('blog2'));
    }

    public function form()
    {
        return view('form');
    }

    public function insert(Request $request)
    {
        Blog::create($this->validatedBlog($request));

        return redirect()->route('author.blog')->with('success', 'บันทึกบทความเรียบร้อย');
    }

    public function delete(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('author.blog')->with('success', 'ลบบทความเรียบร้อย');
    }

    public function change(Blog $blog)
    {
        $blog->update(['status' => !$blog->status]);

        return redirect()->route('author.blog');
    }

    public function edit(Blog $blog)
    {
        return view('edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $blog->update($this->validatedBlog($request));

        return redirect()->route('author.blog')->with('success', 'แก้ไขบทความเรียบร้อย');
    }

    private function validatedBlog(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'max:50'],
            'content' => ['required'],
            'status' => ['required', 'boolean'],
        ], [
            'title.required' => 'กรุณากรอกชื่อบทความ',
            'title.max' => 'หัวข้อไม่เกิน 50 ตัวอักษร',
            'content.required' => 'กรุณาใส่เนื้อหาบทความ',
            'status.required' => 'กรุณาเลือกสถานะ',
        ]);
    }
}
