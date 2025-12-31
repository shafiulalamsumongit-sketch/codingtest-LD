<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShortenedUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ShortenUrlController extends Controller
{
    public function shortenUrl(Request $request)
    {
        try {
            $validated = $request->validate([
                'url' => 'required|url|max:2048'
            ]);

            $existing = ShortenedUrl::where('original_url', $validated['url'])->first();
            if ($existing) {
                return response()->json([
                    'message' => 'URL already shortened',
                    'short_url' => url($existing->short_code)
                ]);
            }

            $shortCode = Str::random(6);

            $short = ShortenedUrl::create([
                'user_id' => $request->user()->id,
                'original_url' => $validated['url'],
                'short_code' => $shortCode
            ]);

            return response()->json([
                'message' => 'URL shortened successfully',
                'short_url' => url($shortCode)
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function redirect($code)
    {
        try {
            $short = ShortenedUrl::where('short_code', $code)->first();

            if (!$short) {
                return response()->json([
                    'message' => 'Short URL not found'
                ], 404);
            }

            return redirect()->away($short->original_url);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}







