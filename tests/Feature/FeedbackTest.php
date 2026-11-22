<?php

use App\Mail\FeedbackMail;
use Illuminate\Mail\SendQueuedMailable;
use Illuminate\Support\Facades\Queue;

it('возвращает 422 json при невалидном телефоне', function () {
    $response = $this->postJson(route('feedback.store'), [
        'phone' => '123',
        'policy' => '1',
        'consent' => '1',
    ]);

    $response->assertStatus(422)
        ->assertJsonPath('success', false)
        ->assertJsonStructure(['message', 'errors']);
});

it('возвращает 422 json без принятых согласий', function () {
    $response = $this->postJson(route('feedback.store'), [
        'phone' => '+7 (900) 123-45-67',
    ]);

    $response->assertStatus(422)
        ->assertJsonPath('success', false)
        ->assertJsonStructure(['errors' => ['policy', 'consent']]);
});

it('ставит письмо в очередь и возвращает успех', function () {
    config(['order.notify_emails' => ['test@example.com']]);

    Queue::fake();

    $response = $this->postJson(route('feedback.store'), [
        'phone' => '+7 (900) 123-45-67',
        'policy' => '1',
        'consent' => '1',
    ]);

    $response->assertOk()
        ->assertJsonPath('success', true);

    Queue::assertPushed(SendQueuedMailable::class, fn ($job) => $job->mailable instanceof FeedbackMail);
});
