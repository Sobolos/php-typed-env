<?php
declare(strict_types=1);

namespace Sobol\PhpTypedEnv;

class TypedEnv
{
    public function __construct(string $directory = __DIR__)
    {
        $envDir ??= dirname($directory);
        EnvLoader::loadEnv($envDir);
    }

    /**
     * Get string env parameter
     *
     * @throws TypedEnvException
     */
    public function getString(string $key, ?string $default = null): string
    {
        $value = getenv($key);
        if ($value === false) {
            if ($default === null) {
                throw new TypedEnvException("Missing required environment variable: $key");
            }
            return $default;
        }
        return $value;
    }

    /**
     * Get integer env parameter
     *
     * @throws TypedEnvException
     */
    public function getInt(string $key, ?int $default = null): int
    {
        $value = getenv($key);
        if ($value === false) {
            if ($default === null) {
                throw new TypedEnvException("Missing required environment variable: $key");
            }
            return $default;
        }

        if (!is_numeric($value)) {
            throw new TypedEnvException("Expected numeric value for $key, got: $value");
        }

        return (int) $value;
    }

    /**
     * Get boolean env parameter as an integer
     *
     * @throws TypedEnvException
     */
    public function getBool(string $key, ?bool $default = null): bool
    {
        $value = getenv($key);
        if ($value === false) {
            if ($default === null) {
                throw new TypedEnvException("Missing required environment variable: $key");
            }
            return $default;
        }

        $return = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (!is_bool($return)) {
            throw new TypedEnvException("Invalid boolean value for $key: $value");
        }

        return $return;
    }

    /**
     * @throws TypedEnvException
     */
    public function getFloat(string $key, ?float $default = null): float
    {
        $value = getenv($key);
        if ($value === false) {
            if ($default === null) {
                throw new TypedEnvException("Missing required environment variable: $key");
            }
            return $default;
        }

        if (!is_numeric($value)) {
            throw new TypedEnvException("Expected float value for $key, got: $value");
        }

        return (float) $value;
    }

    /**
     * @throws TypedEnvException
     */
    public function getArray(string $key, ?array $default = null, string $delimiter = ','): array
    {
        $value = getenv($key);
        if ($value === false) {
            if ($default === null) {
                throw new TypedEnvException("Missing required environment variable: $key");
            }
            return $default;
        }

        return array_map('trim', explode($delimiter, $value));
    }
}