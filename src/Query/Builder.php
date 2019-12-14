<?php

namespace Rennokki\QueryCache\Query;

use DateTime;
use Illuminate\Database\Query\Builder as BaseBuilder;
use Rennokki\QueryCache\Contract\QueryCacheModuleInterface;
use Rennokki\QueryCache\Traits\QueryCacheModule;

class Builder extends BaseBuilder implements QueryCacheModuleInterface
{
    use QueryCacheModule;

    /**
     * {@inheritdoc}
     */
    public function get($columns = ['*'])
    {
        if (! $this->shouldAvoidCache()) {
            return $this->getFromQueryCache('get', $columns);
        }

        return parent::get($columns);
    }
}
