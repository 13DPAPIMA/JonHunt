<?php

namespace App\Services;

class ProfanityFilterService
{
    protected $badWords = [];

    public function __construct()
    {
        $this->loadBadWords();
    }

    protected function loadBadWords()
    {
        $filePath = resource_path('swears.txt');
        if (file_exists($filePath)) {
            $this->badWords = array_map('trim', file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
        }
    }

    public function containsBadWords($text)
    {
        foreach ($this->badWords as $badWord) {
            if (stripos($text, $badWord) !== false) {
                return true;
            }
        }
        return false;
    }
}
