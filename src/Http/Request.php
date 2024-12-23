<?php

namespace Src\Http;

final class Request
{
    private string $currentRequestUri;

    private string $currentRequestMethod;

    private string $baseUrl;

    private array $input;

    private array $headers;

    public function __construct()
    {
        $this->setCurrentRequestInfo();    
        $this->setHeaders();
        $this->setInput();
    }

    public function getCurrentRequestMethod(): string
    {
        return $this->currentRequestMethod;
    }

    public function getCurrentRequestUri(): string
    {
        return $this->currentRequestUri; 
    }

    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function all(): array
    {
        return $this->input;
    }

    public function input(string $inputName, $default = ''): string
    {
        return $this->input[$inputName] ?? $default;
    }

    public function header(string $header, string $defualt = ''): string
    {
        return $this->headers[$header] ?? $defualt;
    }

    public function is(string $route)
    {
        return $this->currentRequestUri === $route;
    }

    private function setCurrentRequestInfo(): void
    {
        $this->currentRequestMethod = strtolower($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);
        $this->currentRequestUri    = $_SERVER['REQUEST_URI'];
        $this->baseUrl              = getenv('base_url');

        unset($_POST['_method']);
    }

    private function setHeaders()
    {
        $this->headers = getallheaders();
    }

    private function setInput()
    {
        $this->input = $this->removeEmptyFields(
            $this->header('X-Requested-With') === 'XMLHttpRequest'
                ? json_decode(file_get_contents('php://input'), true)
                : $_POST
        );

        $_POST = [];
    }

    private function removeEmptyFields($data)
    {
        return array_filter(array_map('trim', $data));
    }
}

