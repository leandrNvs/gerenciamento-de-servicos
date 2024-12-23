<?php

namespace Src\View;

use Src\Filesystem\Filesystem;
use Src\Foundation\Application;
use Src\Session\Session;
use Src\Validation\Validation;

use function Src\Helpers\getMessage;

final class View
{
    public function __construct(
        private Filesystem $filesystem,
        private Template $template,
        private Application $app
    ) {}

    public function render(string $view, array $data = []): void
    {
        $viewPath   = $this->app->build('views.base') . $view . '.html';
        $cachedFile = $this->app->build('views.cache') . $view . '.php';

        $this->filesystem->mkdir(
            $this->filesystem->dir($cachedFile, null, true)
        );

        $view = $this->filesystem->readFile($viewPath);

        $view = $this->template->parse($view, $parameters);

        $this->filesystem->writeFile($cachedFile, $view);

        $data = array_merge($data, $parameters);

        $message = getMessage();

        $data['view_form_error_messages'] = Session::get(Validation::VALIDATE_ERR_MESSAGES);
        $data['view_form_data'] = Session::get(Validation::VALIDATE_FORM_DATA);
        $data['view_has_form_err'] = Session::get(Validation::VALIDATE_HAS_ERROR);

        $data['view_flash_success'] = $message['success'];
        $data['view_flash_message'] = $message['message'];

        foreach($data as $key => $value) {
            $$key = $value;
        }

        require_once $cachedFile;
    }
}