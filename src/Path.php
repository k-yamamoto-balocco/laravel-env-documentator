<?php


namespace GitBalocco\LaravelEnvDocumentator;

class Path
{
    private string $packageRoot;

    public function __construct()
    {
        $this->packageRoot = (string)realpath(__DIR__ . '/../');
    }

    public function getPackageRoot(): string
    {
        return $this->packageRoot;
    }
}