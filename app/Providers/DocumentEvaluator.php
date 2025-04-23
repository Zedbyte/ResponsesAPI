<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class DocumentEvaluator
{
    public function evaluateImage(string $base64Image, string $prompt): string
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $prompt],
                        ['type' => 'image_url', 'image_url' => ['url' => 'data:image/png;base64,' . $base64Image]],
                    ],
                ],
            ],
        ]);

        return $response->choices[0]->message->content;
    }
}
