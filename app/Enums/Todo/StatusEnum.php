<?php

namespace App\Enums\Todo;

enum StatusEnum: string
{
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isCanceled(): bool
    {
        return $this === self::CANCELED;
    }

    public function isCompleted(): bool
    {
        return $this === self::COMPLETED;
    }

    public function getTailWindColor(): string
    {
        return match($this) {
            self::PENDING => 'text-yellow-500',
            self::CANCELED => 'text-red-500',
            self::COMPLETED => 'text-green-500',
        };
    }
}
