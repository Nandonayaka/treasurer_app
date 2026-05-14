<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
        ]);

        Member::create([
            'classroom_id' => $request->classroom_id,
            'name' => $request->name,
            'gender' => $request->gender,
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan!');
    }
}
