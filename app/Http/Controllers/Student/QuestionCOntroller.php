<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SubmitExam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['answers' => function ($query) {
            $query->inRandomOrder();
        }])
            ->where('status', 1)
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('student.pages.questions.index', compact('questions'));
    }

    public function submitExam(SubmitExam $request)
    {
        $validated = $request->validated();
        $userId = Auth::id();
        $correctAnswers = 0;
        $totalQuestions = 0;
        $answersData = [];

        // Process each submitted answer
        foreach ($validated as $key => $answerId) {
            if (str_starts_with($key, 'question_')) {
                $questionId = (int) str_replace('question_', '', $key);
                $answer = \App\Models\Answer::findOrFail($answerId);
                $isCorrect = $answer->is_correct;

                if ($isCorrect) {
                    $correctAnswers++;
                }

                $answersData[] = [
                    'question_id' => $questionId,
                    'selected_answer_id' => $answerId,
                    'is_correct' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $totalQuestions++;
            }
        }

        // Calculate results
        $wrongAnswers = $totalQuestions - $correctAnswers;
        $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        // Save exam results
        $examResult = \App\Models\ExamResult::create([
            'user_id' => $userId,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'wrong_answers' => $wrongAnswers,
            'percentage' => $percentage
        ]);

        // Save individual answers
        $examResult->answers()->createMany($answersData);

        // Redirect to results page with success message
        return redirect()->route('student.dashboard')
            ->with('success', 'Exam submitted successfully! Your score: ' . $percentage . '%');
    }
}
