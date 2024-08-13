<?php

namespace Tests\Feature\Student;

use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use App\Models\QuizSubmission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentQuizTest extends TestCase
{
    use RefreshDatabase;

    public function testStudentCanAttemptQuiz()
    {
        // Create a student user, professor, module, quiz, and quiz questions
        $student = User::factory()->create(['user_type' => 'student']);
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();

        // Assign the professor to the module
        $professor->teaches()->create(['module_id' => $module->module_id]);

        // Enroll the student in the module with enrollment_date
        $student->enrollments()->create([
            'module_id' => $module->module_id,
            'enrollment_date' => now(),
        ]);

        // Create a quiz for the module
        $quiz = Quiz::factory()->create(['module_id' => $module->module_id]);

        // Create quiz questions
        $questions = QuizQuestion::factory()->count(3)->create(['quiz_id' => $quiz->quiz_id]);

        // Define the student's answers
        $answers = [
            $questions[0]->quiz_questions_id => 'A',
            $questions[1]->quiz_questions_id => 'B',
            $questions[2]->quiz_questions_id => 'C',
        ];

        // Prepare the request data
        $quizData = [
            'answers' => $answers,
        ];

        // Send the request to attempt the quiz
        $response = $this->actingAs($student)->post(route('modules.student.quizzes.attempt', ['module_id' => $module->module_id, 'id' => $quiz->quiz_id]), $quizData);

        // Assert the quiz attempt was successful and redirected correctly
        $response->assertRedirect(route('modules.student.quizzes.index', ['module_id' => $module->module_id]));
        $response->assertSessionHas('success', 'Quiz submitted successfully!');

        // Check the quiz attempt and submissions in the database
        $this->assertDatabaseHas('quiz_attempt', [
            'quiz_id' => $quiz->quiz_id,
            'user_id' => $student->user_id,
        ]);

        foreach ($questions as $question) {
            $this->assertDatabaseHas('quiz_submissions', [
                'quiz_questions_id' => $question->quiz_questions_id,
                'user_id' => $student->user_id,
                'submission_answer' => $answers[$question->quiz_questions_id],
            ]);
        }
    }
}