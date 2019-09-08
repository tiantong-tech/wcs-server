<?php

namespace App\Override\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
  public function paginate($pageSize = null, $columns = ['*'], $pageName = 'page', $page = null)
  {
    !$page && ($page = request('page'));
    !$pageSize && ($pageSize = request('pageSize'));
    !$page && ($page = 1);
    !$pageSize && ($pageSize = 15);

    $results = ($total = $this->toBase()->getCountForPagination())
      ? $this->forPage($page, $pageSize)->get($columns)
      : $this->model->newCollection();

    return [
      'meta' => [
        'page' => $page,
        'pageSize' => $pageSize,
        'total' => $total
      ],
      'data' => $results
    ];
  }
}
