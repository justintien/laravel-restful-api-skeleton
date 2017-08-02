<?php

namespace App\Exceptions;

class Error extends \ErrorException
{
    private static $index = [
        'msg' => 0,
        'code' => 1,
    ];

    /**
     * error constant format
     *
     * @var array
     * [
     *     0 => string message,
     *     1 => int code
     * ]
     */
    const ARGUMENT_MISSING = [
        1 => 11,
    ];
    const ARGUMENT_INVALID = [
        1 => 12,
    ];
    const ARGUMENT_TYPE_INVALID = [
        1 => 13,
    ];
    const ARGUMENT_FORMAT_INVALID = [
        1 => 14,
    ];
    const ARGUMENT_LENGTH_INVALID = [
        1 => 15,
    ];
    const ARGUMENT_IS_ZERO = [
        1 => 16,
    ];
    const ARGUMENT_LESS_THAN_MIN = [
        1 => 17,
    ];
    const ARGUMENT_OVER_MAX = [
        1 => 18,
    ];

    const AUTHROIZATION_FAIL = [
        1 => 21,
    ];

    const TOKEN_ID_INVALID = [
        1 => 31,
    ];
    const TOKEN_APPKEY_INVALID = [
        1 => 32,
    ];
    const TOKEN_DATE_INVALID = [
        1 => 33,
    ];
    const TOKEN_LENGTH_INVALID = [
        1 => 34,
    ];

    const PROTOCOL_SEQUENCE_TIMEOUT = [
        1 => 97,
    ];
    const DATABASE_ERROR = [
        1 => 98,
    ];
    const UNKNOWN = [
        1 => 99,
    ];

    /**
     * @var array
     */
    private $arguments = [];
    private $statusCode = 400;
    private $headers = [];

    public function __construct(string $key = 'UNKNOWN')
    {
        $this->arguments = func_get_args();
        parent::__construct(
            $this->toMessage($key),
            $this->toCode($key)
        );
    }
    public function getArgument(int $idx)
    {
        return $this->arguments[$idx] ?? null;
    }
    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }
    public function getHeaders(): array
    {
        return $this->headers;
    }
    /**
     * Set response headers.
     *
     * @param array $headers Response headers
     */
    public function setHeaders(array $headers): array
    {
        $this->headers = $headers;
    }

    protected function toMessage(string $key): string
    {
        if (defined(__CLASS__ . '::' . $key)) {
            $idx = self::$index['msg'];
            return constant(__CLASS__ . '::' . $key)[$idx] ?? $key;
        }
        return $key;
    }
    protected function toCode(string $key): int
    {
        $idx = self::$index['code'];
        if (defined(__CLASS__ . '::' . $key)) {
            return constant(__CLASS__ . '::' . $key)[$idx] ?? static::UNKNOWN[$idx];
        }
        return static::UNKNOWN[$idx];
    }
}
