<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class User
{
    /**
     * SerializedName("comments")
     */
    private array $comments = [];

    public function getComments(): array {
        return $this->comments;
    }

    public function addComment(Comment $comment): void {
        $this->comments[$comment->getId()] = $comment;
    }

    // UNCOMMENT THIS METHOD TO MAKE TEST PASS
//    public function removeComment(Comment $comment): void {
//        unset(
//            $this->comments[$comment->getId()]
//        );
//    }
}