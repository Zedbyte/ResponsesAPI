<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class Evaluator extends Controller
{
    public function evaluate(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        // If it's a PDF, convert to image (not covered here) or reject for now
        $file = $request->file('document');
        $mime = $file->getMimeType();

        if ($mime === 'application/pdf') {
            return back()->with('result', 'PDF support is coming soon! Try an image (JPG/PNG) for now.');
        }

        $imageData = file_get_contents($file->getRealPath());
        $base64Image = base64_encode($imageData);

        $prompt = <<<EOD
Tell me what you see.
EOD;

        try {
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

            $result = $response->choices[0]->message->content;
            return back()->with('result', $result);
        } catch (\Exception $e) {
            return back()->with('result', 'Error: ' . $e->getMessage());
        }
    }
}
