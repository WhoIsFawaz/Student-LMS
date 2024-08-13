<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Module;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfessorQuizController extends Controller
{
    // Display a list of quizzes for the professor within a module.
    public function index($module_id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $quizzes = Quiz::where('module_id', $module_id)->get(); // Retrieves all quizzes associated with the module.
        return view('professor.quizzes.index', compact('module', 'quizzes', 'module_id')); // Returns the 'index' view for quizzes, passing the module and quizzes data.
    }

    // Show the form to create a new quiz for the professor.
    public function create($module_id)
    {
        return view('professor.quizzes.create', compact('module_id')); // Returns the 'create' view for quizzes, passing the module ID.
    }

    // Store the new quiz created by the professor.
    public function store(Request $request, $module_id)
    {
        try {
            $request->validate([ // Validates the incoming request data.
                'module_id' => 'required', // The module ID is required.
                'title' => 'required', // The quiz title is required.
                'description' => 'required', // The quiz description is required.
                'datetime' => 'required|date', // The quiz date and time are required and must be a valid date.
                'duration' => 'required|integer', // The quiz duration is required and must be an integer.
                'questions.*' => 'required', // Each question is required.
                'options.*.*' => 'required', // Each option for each question is required.
                'correct_options.*' => 'required', // Each correct option is required.
                'marks.*' => 'required|integer', // Each mark is required and must be an integer.
            ]);

            $quiz = Quiz::create([ // Creates a new quiz.
                'module_id' => $module_id, // Sets the module ID.
                'quiz_title' => $request->title, // Sets the quiz title.
                'quiz_description' => $request->description, // Sets the quiz description.
                'quiz_date' => $request->datetime, // Sets the quiz date.
                'duration' => $request->duration, // Sets the quiz duration.
            ]);

            foreach ($request->questions as $index => $question) { // Iterates over each question.
                QuizQuestion::create([ // Creates a new quiz question.
                    'quiz_id' => $quiz->quiz_id, // Sets the quiz ID.
                    'question' => $question, // Sets the question text.
                    'option_a' => $request->options[$index][0], // Sets option A.
                    'option_b' => $request->options[$index][1], // Sets option B.
                    'option_c' => $request->options[$index][2], // Sets option C.
                    'option_d' => $request->options[$index][3], // Sets option D.
                    'correct_option' => substr($request->correct_options[$index], -1), // Sets the correct option.
                    'marks' => $request->marks[$index], // Sets the marks for the question.
                ]);
            }

            return redirect()->route('modules.professor.quizzes.index', ['module_id' => $module_id])
                ->with('success', 'Quiz created successfully.'); // Redirects to the quizzes index with a success message.
        } catch (\Exception $e) {
            return redirect()->route('modules.professor.quizzes.create', ['module_id' => $module_id])
                ->with('error', $e->getMessage())
                ->setStatusCode(500); // Redirects to the quiz creation page with an error message.
        }
    }

    // Show the form to edit an existing quiz for the professor.
    public function edit($module_id, $id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $quiz = Quiz::with('questions')->where('quiz_id', $id)->where('module_id', $module_id)->firstOrFail(); // Finds the quiz by its ID and module ID, including its questions.
        return view('professor.quizzes.edit', compact('quiz', 'module', 'module_id')); // Returns the 'edit' view for quizzes, passing the quiz and module data.
    }

    // Show a specific quiz for the professor.
    public function show($module_id, $id)
    {
        $module = Module::findOrFail($module_id); // Finds the module by its ID, or fails with a 404 error if not found.
        $quiz = Quiz::with('questions')->where('quiz_id', $id)->where('module_id', $module_id)->firstOrFail(); // Finds the quiz by its ID and module ID, including its questions.
        return view('professor.quizzes.show', compact('quiz', 'module', 'module_id')); // Returns the 'show' view for quizzes, passing the quiz and module data.
    }

    public function update(Request $request, $module_id, $id)
    {
        // Log the incoming request data
        Log::info('Incoming request data: ', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'datetime' => 'required|date',
            'duration' => 'required|integer',
            'questions.*' => 'required|string',
            'options.*.*' => 'required|string',
            'correct_options.*' => 'required|string',
            'marks.*' => 'required|integer',
        ]);

        // Log the validated data
        Log::info('Validated data: ', $validated);

        try {
            $quiz = Quiz::where('quiz_id', $id)->where('module_id', $module_id)->firstOrFail();

            // Log the quiz data before updating
            Log::info('Quiz before update: ', $quiz->toArray());

            $quiz->update([
                'quiz_title' => $validated['title'],
                'quiz_description' => $validated['description'],
                'quiz_date' => $validated['datetime'],
                'duration' => $validated['duration'],
            ]);

            // Log the quiz data after updating
            Log::info('Quiz after update: ', $quiz->toArray());

            // Remove existing questions and their options
            QuizQuestion::where('quiz_id', $quiz->quiz_id)->delete();

            // Add updated questions
            foreach ($request->questions as $index => $question) {
                $quizQuestion = QuizQuestion::create([
                    'quiz_id' => $quiz->quiz_id,
                    'question' => $question,
                    'option_a' => $request->options[$index][0],
                    'option_b' => $request->options[$index][1],
                    'option_c' => $request->options[$index][2],
                    'option_d' => $request->options[$index][3],
                    'correct_option' => $request->correct_options[$index],
                    'marks' => $request->marks[$index],
                ]);
            }

            return redirect()->route('modules.professor.quizzes.index', ['module_id' => $module_id])
                ->with('success', 'Quiz updated successfully.');
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error updating quiz: ' . $e->getMessage());

            return redirect()->route('modules.professor.quizzes.edit', ['module_id' => $module_id, 'id' => $id])
                ->with('error', $e->getMessage())
                ->setStatusCode(500);
        }
    }




    // Delete a quiz for the professor.
    public function destroy($module_id, $id)
    {
        $quiz = Quiz::where('module_id', $module_id)->findOrFail($id); // Finds the quiz by its module and ID, or fails with a 404 error if not found.
        $quiz->delete(); // Deletes the quiz.

        return redirect()->route('modules.professor.quizzes.index', ['module_id' => $module_id])
            ->with('success', 'Quiz deleted successfully.'); // Redirects to the quizzes index with a success message.
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
}