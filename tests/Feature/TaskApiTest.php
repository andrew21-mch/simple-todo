<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_paginated_tasks_in_index()
    {
        // Create some tasks
        Task::factory()->count(15)->create();

        // Call the index route (assumed route is '/tasks')
        $response = $this->getJson('/api/tasks');

        // Assert the response is OK (200)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response contains the correct structure
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'status',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
        ]);

        // Assert that the number of tasks returned is 10 (per page)
        $response->assertJsonCount(10, 'data');
    }

    /** @test */
    public function it_shows_a_single_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Call the show route (assumed route is '/tasks/{id}')
        $response = $this->getJson("/api/tasks/{$task->id}");

        // Assert the response is OK (200)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response contains the task data
        $response->assertJson([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
        ]);
    }

    /** @test */
    public function it_creates_a_new_task()
    {
        // Data to be sent with the request
        $data = [
            'title' => 'New Task',
            'description' => 'Task description',
            'status' => 'pending',
        ];

        // Call the store route (assumed route is '/tasks')
        $response = $this->postJson('/api/tasks', $data);

        // Assert the response is created (201)
        $response->assertStatus(Response::HTTP_CREATED);

        // Assert the task was created in the database
        $this->assertDatabaseHas('tasks', $data);
    }

    /** @test */
    public function it_updates_an_existing_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Data to be sent with the request for updating the task
        $updatedData = [
            'title' => 'Updated Task',
            'description' => 'Updated description',
            'status' => 'completed',
        ];

        // Call the update route (assumed route is '/tasks/{id}')
        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);

        // Assert the response is OK (200)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the task was updated in the database
        $this->assertDatabaseHas('tasks', $updatedData);
        $this->assertDatabaseMissing('tasks', [
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
        ]);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        // Create a task
        $task = Task::factory()->create();

        // Call the destroy route (assumed route is '/tasks/{id}')
        $response = $this->deleteJson("/api/tasks/{$task->id}");

        // Assert the response is no content (204)
        $response->assertStatus(Response::HTTP_NO_CONTENT);

        // Assert the task was deleted from the database
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /** @test */
    public function it_validates_task_creation_data()
    {
        // Send invalid data to create a task
        $invalidData = [
            'title' => '', // Title is required, empty string is invalid
            'status' => 'invalid-status', // Invalid status
        ];

        // Call the store route with invalid data
        $response = $this->postJson('/api/tasks', $invalidData);

        // Assert the response status is Unprocessable Entity (422)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert the response contains validation errors
        $response->assertJsonValidationErrors(['title', 'status']);
    }
}
