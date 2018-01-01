<?php
/**
 * User: Salavat Sitdikov
 */

namespace SSitdikov\TelegraphAPI\Exception;


use Throwable;

class ContentTextRequired extends \Exception
{
    public function __construct(string $message = "Content text is required", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}