<?php

namespace Src\Database;

use Src\Support\Database\QueryBuilder;

final class Paginate
{
    private array $data = [];

    private string $controls = '';

    public function __construct(private string $tableName) {}

    public function __set(string $key, mixed $value): void
    {
        if($key === 'where') {
            $this->data['where'][] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    public function __get(string $key): mixed
    {
        return $this->data[$key];
    }

    public function execute()
    {
        $queryForData = QueryBuilder::table($this->tableName)
            ->select();

        $queryForCount = QueryBuilder::table($this->tableName)->count('id', 'totalPage');

        foreach($this->where as $where) {
            $queryForData->where(...$where);
            $queryForCount->where(...$where);
        }

        $queryForData->limit($this->quantity)->skip($this->quantity * ($this->page - 1));

        $data  = $queryForData->execute();
        $count = $queryForCount->execute();

        $this->totalPages = ceil($count['data'][0]['totalPage'] / $this->quantity);

        return ['data' => $data['data'], 'totalPages' => $this->totalPages];
    }

    public function createControls($totalPages)
    {
        if($totalPages == 0) return $this;

        $previous = (int) $this->page - 1;
        $next     = (int) $this->page + 1;

        if($this->page > 1) {
            $this->controls = "<a href=\"{{url}}/pagina/1\">Primeira página</a>";
            $this->controls .= "<a href=\"{{url}}/pagina/{$previous}\">&lt;&lt;</a>";
        }

        if($totalPages <= 5) {
            for($i = 1; $i <= $totalPages; $i++) {
                $class = $this->page == $i? 'active' : null;
                $this->controls .= "<a href=\"{{url}}/pagina/{$i}\" class=\"$class\">{$i}</a>";
            }
        } else {
            if(($totalPages - 5) > $this->page) {
                for($i = $this->page; $i < ($this->page + 3); $i++) {
                    $class = $this->page == $i? 'active' : null;
                    $this->controls .= "<a href=\"{{url}}/pagina/{$i}\" class=\"$class\">{$i}</a>";
                }

                if($totalPages > 3) {
                    $this->controls .= "<a href='javascript:void(0)'>...</a>";
                }

                for($i = 3; $i >= 1; $i--) {
                    $page = ($totalPages + 1) - $i;
                    $class = $this->page == $page? 'active' : null;
                    $this->controls .= "<a href=\"{{url}}/pagina/{$page}\" class=\"$class\">{$page}</a>";
                }
            } else {
                for($i = $totalPages - 5; $i <= $totalPages; $i++) {
                    $class = $this->page == $i? 'active' : null;
                    $this->controls .= "<a href=\"{{url}}/pagina/{$i}\" class=\"$class\">{$i}</a>";
                }
            }
        }
        
        if($this->page < $this->totalPages) {
            $this->controls .= "<a href=\"{{url}}/pagina/{$next}\">&gt;&gt;</a>";
            $this->controls .= "<a href=\"{{url}}/pagina/{$totalPages}\">Última página</a>";
        }

        return $this;
    }

    public function controls($url)
    {
        return str_replace('{{url}}', $url, $this->controls);
    }
}