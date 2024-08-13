<?php

namespace Tests\Feature\Professor;

use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessorQuizTest extends TestCase
{
    use RefreshDatabase;

    public function testProfessorCanCreateQuiz()
    {
        // Create a professor user and a module
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();

        // Assign the professor to the module
        $professor->teaches()->create(['module_id' => $module->module_id]);

        // Define quiz data
        $quizData = [
            'module_id' => $module->module_id,
            'title' => 'Test Quiz',
            'description' => 'Test Description',
            'datetime' => '2024-07-21 10:00:00',
            'duration' => 60,
            'questions' => ['What is PHP?'],
            'options' => [['Hypertext Preprocessor', 'Personal Home Page', 'Pre Hypertext Processor', 'Preprocessor Home Page']],
            'correct_options' => ['A'],
            'marks' => [5],
        ];

        // Send the request to create a quiz
        $response = $this->actingAs($professor)->post(route('modules.professor.quizzes.store', ['module_id' => $module->module_id]), $quizData);

        // Assert the quiz was created and redirected correctly
        $response->assertRedirect(route('modules.professor.quizzes.index', ['module_id' => $module->module_id]));

        // Check the quiz and quiz questions in the database
        $this->assertDatabaseHas('quiz', [
            'module_id' => $module->module_id,
            'quiz_title' => $quizData['title'],
        ]);

        $quiz = Quiz::where('module_id', $module->module_id)->first();

        $this->assertDatabaseHas('quiz_questions', [
            'quiz_id' => $quiz->quiz_id,
            'question' => 'What is PHP?',
            'option_a' => 'Hypertext Preprocessor',
            'option_b' => 'Personal Home Page',
            'option_c' => 'Pre Hypertext Processor',
            'option_d' => 'Preprocessor Home Page',
            'correct_option' => 'A',
            'marks' => 5,
        ]);
    }

    public function testProfessorCanEditQuiz()
    {
        // Create a professor user and a module
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();

        // Assign the professor to the module
        $professor->teaches()->create(['module_id' => $module->module_id]);

        // Create a quiz
        $quiz = Quiz::factory()->create(['module_id' => $module->module_id]);

        // Create quiz questions
        $quizQuestion = QuizQuestion::factory()->create(['quiz_id' => $quiz->quiz_id]);

        // Define updated quiz data
        $quizData = [
            'title' => 'Updated Quiz Title',
            'description' => 'Updated Description',
            'datetime' => '2024-08-21 10:00:00',
            'duration' => 90,
            'questions' => ['Updated Question'],
            'options' => [['Updated A', 'Updated B', 'Updated C', 'Updated D']],
            'correct_options' => ['B'],
            'marks' => [10],
        ];

        // Send the request to update the quiz
        $response = $this->actingAs($professor)->patch(route('modules.professor.quizzes.update', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]), $quizData);

        // Assert the quiz was updated and redirected correctly
        $response->assertRedirect(route('modules.professor.quizzes.index', ['module_id' => $module->module_id]));

        // Check the updated quiz and quiz questions in the database
        $this->assertDatabaseHas('quiz', [
            'quiz_id' => $quiz->quiz_id,
            'quiz_title' => $quizData['title'],
        ]);

        $this->assertDatabaseHas('quiz_questions', [
            'quiz_id' => $quiz->quiz_id,
            'question' => 'Updated Question',
            'option_a' => 'Updated A',
            'option_b' => 'Updated B',
            'option_c' => 'Updated C',
            'option_d' => 'Updated D',
            'correct_option' => 'B',
            'marks' => 10,
        ]);
    }

    public function testProfessorCanDeleteQuiz()
    {
        // Create a professor user and a module
        $professor = User::factory()->create(['user_type' => 'professor']);
        $module = Module::factory()->create();

        // Assign the professor to the module
        $professor->teaches()->create(['module_id' => $module->module_id]);

        // Create a quiz
        $quiz = Quiz::factory()->create(['module_id' => $module->module_id]);

        // Send the request to delete the quiz
        $response = $this->actingAs($professor)->delete(route('modules.professor.quizzes.destroy', ['module_id' => $module->module_id, 'quiz' => $quiz->quiz_id]));

        // Assert the quiz was deleted and redirected correctly
        $response->assertRedirect(route('modules.professor.quizzes.index', ['module_id' => $module->module_id]));

        // Check the quiz and quiz questions are no longer in the database
        $this->assertDatabaseMissing('quiz', [
            'quiz_id' => $quiz->quiz_id,
        ]);

        $this->assertDatabaseMissing('quiz_questions', [
            'quiz_id' => $quiz->quiz_id,
        ]);
    }
}