<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ResultController extends Controller {
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ExamResult::select('id', 'user_id', 'total_questions', 'correct_answers', 'percentage')->with('user');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($row) {
                    return $row->user->name;
                })
                ->rawColumns(['user'])
                ->make(true);
        }
        return view('admin.pages.result.index');
    }
}
