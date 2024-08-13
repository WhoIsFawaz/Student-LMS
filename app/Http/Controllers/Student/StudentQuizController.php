<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Module;
use App\Models\QuizAttempt;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use App\Models\QuizSubmission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    // Display a list of quizzes for the student within a module.
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $quizzes = Quiz::where('module_id', $module_id)->get(); // Retrieves all quizzes associated with the module.
        $completedQuizzes = QuizAttempt::where('user_id', Auth::id()) // Retrieves all quiz attempts by the authenticated user.
            ->whereHas('quiz', function ($query) use ($module_id) {
                $query->where('module_id', $module_id); 
            })
            ->with('quiz') // Includes the quiz details with the attempt.
            ->orderBy('created_at', 'desc') // Orders the attempts by creation date, descending.
            ->get();

        foreach ($completedQuizzes as $attempt) { // Iterates over each completed quiz attempt.
            $totalMarks = $this->calculateTotalMarks($attempt->quiz_id); // Calculates the total marks for the quiz.
            $attempt->score = $attempt->total_marks . '/' . $totalMarks; // Sets the score for the attempt.
            $attempt->grade = $this->calculateGrade(($attempt->total_marks / $totalMarks) * 100); // Sets the grade for the attempt.
        }

        return view('student.quizzes.index', compact('module', 'quizzes', 'completedQuizzes', 'module_id')); // Returns the 'index' view for student quizzes, passing the module, quizzes, and completed attempts data.
    }

    // Show a specific quiz for the student.
    public function show($module_id, $id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $quiz = Quiz::with('questions')->where('quiz_id', $id)->where('module_id', $module_id)->firstOrFail(); // Finds the quiz by its ID and module ID, including its questions.
        return view('student.quizzes.show', compact('quiz', 'module', 'module_id')); // Returns the 'show' view for quizzes, passing the quiz and module data.
    }

    // Helper method to calculate the total marks for a quiz.
    private function calculateTotalMarks($quiz_id)
    {
        return QuizQuestion::where('quiz_id', $quiz_id)->sum('marks'); // Sums the marks for all questions in the quiz.
    }

    // Helper method to calculate the grade based on a percentage.
    private function calculateGrade($percentage)
    {
        if ($percentage >= 85) {
            return 'A+';
        } elseif ($percentage >= 80) {
            return 'A';
        } elseif ($percentage >= 75) {
            return 'A-';
        } elseif ($percentage >= 70) {
            return 'B+';
        } elseif ($percentage >= 65) {
            return 'B';
        } elseif ($percentage >= 60) {
            return 'B-';
        } elseif ($percentage >= 55) {
            return 'C+';
        } elseif ($percentage >= 50) {
            return 'C';
        } elseif ($percentage >= 45) {
            return 'D+';
        } elseif ($percentage >= 40) {
            return 'D';
        } else {
            return 'F';
        }
    }

    public function attempt(Request $request, $module_id, $id)
    {
        $user = Auth::user(); // Retrieves the authenticated user.
        $quiz = Quiz::where('quiz_id', $id)->where('module_id', $module_id)->firstOrFail(); // Finds the quiz by its ID and module ID, or fails with a 404 error if not found.

        $totalMarks = 0;

        $quizAttempt = QuizAttempt::create([ // Creates a new quiz attempt.
            'quiz_id' => $quiz->quiz_id, // Sets the quiz ID.
            'user_id' => $user->user_id, // Sets the user ID.
            'total_marks' => 0, // Initializes the total marks.
        ]);

        foreach ($quiz->questions as $question) { // Iterates over each question in the quiz.
            $submittedAnswer = $request->input('answers.' . $question->quiz_questions_id, ''); // Retrieves the submitted answer or empty string if not provided.
            $correctAnswer = $question->correct_option; // Retrieves the correct answer.

            $isCorrect = $submittedAnswer === $correctAnswer; // Checks if the answer is correct.
            $marksObtained = $isCorrect ? $question->marks : 0; // Assigns marks if the answer is correct.
            $totalMarks += $marksObtained; // Updates the total marks.

            QuizSubmission::create([ // Creates a new quiz submission.
                'quiz_questions_id' => $question->quiz_questions_id, // Sets the question ID.
                'user_id' => $user->user_id, // Sets the user ID.
                'submission_answer' => $submittedAnswer, // Sets the submitted answer.
                'is_correct' => $isCorrect, // Sets whether the answer is correct.
                'marks' => $marksObtained, // Sets the marks obtained.
            ]);
        }

        $quizAttempt->update(['total_marks' => $totalMarks]); // Updates the total marks for the quiz attempt.

        return redirect()->route('modules.student.quizzes.index', ['module_id' => $module_id])
            ->with('success', 'Quiz submitted successfully!'); // Redirects to the student quizzes index with a success message.
    }
}