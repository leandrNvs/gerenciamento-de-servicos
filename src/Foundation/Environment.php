<?php

namespace Src\Foundation;

use Src\Filesystem\Filesystem;

final class Environment
{
    public function __construct(private Filesystem $filesystem) {}

    public function start(string $env_file): void
    {
        $vars = array_filter(explode("\n", $this->filesystem->readFile($env_file)));

        foreach($vars as $var) {
            putenv($var);
        }
    }
}
