<?php

namespace App\Custom;

class SentComments
{
    /**
     * Check if a comment/review was sent recently (within 10 minutes).
     *
     * @param int $id The ID of the comment/review.
     * @return bool
     */
    public static function isComment(int $id): bool
    {
        $comments = session('sent_comments', []);

        if (!isset($comments[$id])) {
            return false;
        }

        $sentTime = $comments[$id];
        $now = time();
        $tenMinutes = 10 * 60;

        return ($now - $sentTime) <= $tenMinutes;
    }

    /**
     * Register a comment/review as sent.
     *
     * @param int $id
     */
    public static function addComment(int $id): void
    {
        $comments = session('sent_comments', []);
        $comments[$id] = time();
        session(['sent_comments' => $comments]);
    }

    /**
     * Remove a comment/review from the tracked session list.
     *
     * @param int $id
     */
    public static function removeComment(int $id): void
    {
        $comments = session('sent_comments', []);
        unset($comments[$id]);
        session(['sent_comments' => $comments]);
    }
}
