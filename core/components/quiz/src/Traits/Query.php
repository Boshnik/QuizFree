<?php

namespace Boshnik\Quiz\Traits;

trait Query
{
    private function getQuery($classKey, array $where = [], $options = [])
    {
        $query = $this->modx->newQuery($classKey);
        $query->where($where);
        $query->limit(
            $options['limit'] ?? 0,
            $options['offset'] ?? 0
        );
        $query->sortby(
            $options['sortby'] ?? 'menuindex',
            $options['sortdir'] ?? 'asc'
        );
        if (isset($options['fields'])) {
            $query->select($options['fields']);
        }

        return $query;
    }

    /**
     * @param $className
     * @param array $where
     * @param $options
     * @return mixed
     */
    public function getObject($className, array $where = [], $options = []): mixed
    {
        $query = $this->getQuery($className, $where, $options);

        return $this->modx->getObject($className, $query);
    }

    /**
     * @param $className
     * @param array $where
     * @param string $sortby
     * @param string $sortdir
     * @return mixed
     */
    public function getCollection($className, array $where = [], $options = []): mixed
    {
        $query = $this->getQuery($className, $where, $options);

        return $this->modx->getCollection($className, $query);
    }

    /**
     * @param $className
     * @param array $where
     * @param array $options
     * @return mixed
     */
    public function getFetch($className, array $where = [], array $options = []): mixed
    {
        $options['limit'] = 1;
        $query = $this->getQuery($className, $where, $options);
        $query->select($this->modx->getSelectColumns($className, $className, '', '', false));
        $query->prepare();
        $query->stmt->execute();

        return $query->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $className
     * @param $where
     * @param $options
     * @return mixed
     */
    public function getFetchAll($className, array $where = [], array $options = []): mixed
    {
        $query = $this->getQuery($className, $where, $options);
        $query->select($this->modx->getSelectColumns($className, $className, '', '', false));
        $query->prepare();
        $query->stmt->execute();

        return $query->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getMenuindex($className, $where = [])
    {
        return $this->getMax($className, $where) + 1;
    }

    public function getMax($className, $where = [], $column = 'menuindex')
    {
        $query = $this->getQuery($className, $where);
        $query->select($column);
        $query->prepare();
        $query->stmt->execute();
        if ($results = $query->stmt->fetchAll(\PDO::FETCH_COLUMN)) {
            $result = max($results);
        }

        return $result ?? -1;
    }
}