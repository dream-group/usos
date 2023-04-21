<?php

declare(strict_types=1);

namespace Dream\USOS;

final class Env
{
    /** @var string */
    private $appEnv;

    public function __construct(string $appEnv)
    {
        $this->appEnv = $appEnv;
    }

    public function isDebug(): bool
    {
        return $this->appEnv === 'development';
    }
}
