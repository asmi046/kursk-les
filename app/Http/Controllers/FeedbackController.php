<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Mail\FeedbackMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function store(FeedbackRequest $request): JsonResponse
    {
        Mail::to(config('order.notify_emails', []))->queue(
            new FeedbackMail($request->input('phone'))
        );

        return response()->json([
            'success' => true,
            'message' => 'Спасибо! Ваша заявка принята, мы свяжемся с вами в ближайшее время.',
        ]);
    }
}
