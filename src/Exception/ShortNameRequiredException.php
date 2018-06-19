<?php declare(strict_types=1);

namespace SSitdikov\TelegraphAPI\Exception;

use Throwable;

class ShortNameRequiredException extends \Exception
{
    public function __construct(string $message = "Short name is required", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
