<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $members = Member::where('nama', 'LIKE', "%{$query}%")->get();
        return response()->json($members);
    }
}
