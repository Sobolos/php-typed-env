<?php
declare(strict_types=1);

namespace Sobol\PhpTypedEnv;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidEncodingException;
use Dotenv\Exception\InvalidFileException;

class EnvLoader
{

    /**
     * @param string $filePath
     * @return void
     *
     * @throws InvalidEncodingException|InvalidFileException
     */
    public static function loadEnv(string $filePath): void
    {
        $files = ['.env'];

        $local = $filePath . '/.env.local';
        if (file_exists($local)) {
            $files[] = '.env.local';
        }

        $dotenv = Dotenv::createUnsafeImmutable($filePath, $files);
        $dotenv->safeLoad();
    }
}