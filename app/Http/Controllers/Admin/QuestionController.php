<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Question\StoreRequest;
use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Question::select('id', 'question', 'marks', 'status');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="'.route('admin.questions.edit', $row->id).'" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>';
                    $btn .= '<button type="button" class="btn btn-sm btn-danger delete-btn ml-1" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->editColumn('status', function($row) {
                    return $row->status ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        return view('admin.pages.question.index');
    }

    public function create()
    {
        return view('admin.pages.question.create');
    }

    public function store(StoreRequest $request)
    {
        try{
            DB::beginTransaction();
            $question = Question::create([
                'question' => $request->question,
                'marks' => $request->marks,
                'status' => $request->status,
            ]);

            foreach ($request->options as $index => $option) {
                Answer::create([
                    'question_id' => $question->id,
                    'answer' => $option,
                    'is_correct' => ((int) $request->correct_option === $index) ? 1 : 0,
                ]);
            }
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('admin.questions.index')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully');
    }

    public function show(Question $question)
    {
        return view('admin.pages.question.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $question = Question::with('answers')->find($question->id);
        return view('admin.pages.question.create', compact('question'));
    }

    public function update(Request $request, Question $question)
    {

        $question = Question::find($question->id);
        if (!$question) {
            return redirect()->route('admin.questions.index')->with('error', 'Question not found');
        }
        try{
            DB::beginTransaction();
            $question->update([
                'question' => $request->question,
                'marks' => $request->marks,
                'status' => $request->status,
            ]);

            Answer::where('question_id', $question->id)->update(['is_correct' => 0]);

            if (isset($request->correct_option) && $request->correct_option !== null) {
                Answer::where('question_id', $question->id)
                    ->where('answer', $request->options[$request->correct_option])
                    ->update(['is_correct' => 1]);
            }
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
            return redirect()->route('admin.questions.index')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully');
    }

    public function destroy(Question $question)
    {
        $question = Question::find($question->id);
        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found.'
            ], 404);
        }
        try {
            DB::beginTransaction();
            $question->answers()->delete();
            $question->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting question: ' . $e->getMessage()
            ], 500);
        }
    }
}
