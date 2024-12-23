<?php

namespace Src\View;

use Src\Filesystem\Filesystem;
use Src\Foundation\Application;

final class Template
{

    public function __construct(
        private Filesystem $filesystem,
        private Application $app
    ) { }

    public function parse(string $view, mixed &$data): string
    {
        $view = $this->template($view);

        $data = $this->extractVars($view, $view);

        $view = $this->reusables($view);

        $replacement = [
            '/@if\((.+?)\)/' => "<?php if($1): ?>",
            '/@endif/' => "<?php endif; ?>",
            '/@!(delete|put|patch)\(\)/' => "<?php echo \Src\Helpers\method('$1'); ?>",
            '/@!(.+?)\((.*?)\)/' => "<?php echo \Src\Helpers\\\\$1($2); ?>",
            '/\{\{(.+?)\}\}/' => "<?=htmlspecialchars($1);?>",
            '/\{\!\!\s*(.+?)\s*\!\!\}/' => "<?=$1;?>",
            '/@err\((.+?)([,\s+](.+?))?\)/' => "<?= \$view_form_error_messages[$1][$3] ?? null ?>",
            '/\$view_form_error_messages\[(.+?)\]\[\]/' => "\$view_form_error_messages[$1]",
            '/@bag\((.+?)([,\s+](.+?))?\)/' => "<?= \$view_form_data[$1][$3] ?? null ?>",
            '/\$view_form_data\[(.+?)\]\[\]/' => "\$view_form_data[$1]",
            '/@message/' => "<?= \$view_flash_message ?? null ?>",
            '/@success\((.+?),\s+(.+?)\)/' => "<?= \$view_flash_success? $1 : $2 ?>",
            '/@hasError\((.+?)\)/' => "<?= \$view_has_form_err? $1 : null ?>"
        ];

        $view = preg_replace(array_keys($replacement), $replacement, $view);

        return $view;
    }

    private function template(string $view): string
    {
        if(preg_match('/@template\((.+?)\)/', $view, $match)) {
            $template = $this->filesystem->readFile(
                $this->app->build('views.base') . $match[1] . '.html'
            );

            $view = str_replace('{{body}}', $view, $template);
            $view = str_replace($match[0], '', $view);
        }

        return $view;
    }

    private function extractVars(string $from, &$view)
    {
        if(preg_match('/@vars\(\[((.|\s)+?)\]\)/', $from, $match))
        {
            $arr = explode(',', $match[1]);
            $arr = array_map(fn($i) => explode('=>', str_replace('\'', '', $i)), $arr);

            $arr = array_reduce($arr, function($carry, $item) {
                $carry[trim($item[0])] = trim($item[1]);

                return $carry;
            }, []);

            $view = str_replace($match[0], '', $view);

            return $arr;
        }

        return [];
    }

    protected function reusables($view)
    {
        if(preg_match_all("/@reusable\('(.+)'\)((.|\s)*?)@endreusable/", $view, $matches)) {
            $cleaner = $matches[0];
            $reusable = array_combine($matches[1], $matches[2]);

            preg_match_all("/@use\('(.+)',\s*\[((.|\s)*?)\]\)/", $view, $matches);

            $useToReplace = $matches[0];
            $useKeys = $matches[1];

            $useDatas = array_map(function($i) {
                $i = trim($i);
                $i = preg_replace("/\n|\s{2,}|(?<=',)\s/", '', $i);

                preg_match_all("/'(.*?)'\s*=\>\s*'(.*?)'/", $i, $match);

                $match[1] = array_map(fn($j) => "$$j", $match[1]);

                return array_combine($match[1], $match[2]);
            }, $matches[2]);

            foreach($useKeys as $key => $value):
                $data = str_replace(array_keys($useDatas[$key]), $useDatas[$key], $reusable[$value]);
                $view = str_replace($useToReplace[$key], $data, $view);
            endforeach;

            return trim(str_replace($cleaner, '', $view));
        }
        
        return $view;
    }
}