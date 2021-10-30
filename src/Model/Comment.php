<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\SerializedName;

class Comment
{
    /**
     * SerializedName("id")
     */
    private int $id;

    public function setId(int $id): self {
        $this->id = $id;

        return $this;
    }

    public function getId(): int {
        return $this->id;
    }
}