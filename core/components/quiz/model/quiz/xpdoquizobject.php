<?php

use Boshnik\Quiz\Traits\Helps;
class xPDOQuizObject extends xPDOSimpleObject
{
    use Helps;

    public int $quiz_id = 0;
    public array $classKeys = [
        'form' => \QuizForm::class,
        'step' => \QuizStep::class,
        'field' => \QuizField::class,
        'value' => \QuizFieldValue::class,
        'result' => \QuizResult::class,
    ];

    public function getQuery($classKey, array $where = [], array $options = []): xPDOQuery
    {
        $query = $this->xpdo->newQuery($classKey);
        $query->where(array_merge([
            'form_id' => $this->quiz_id ?: $this->id,
            'published' => 1,
        ], $where));
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

    public function getItem(string $className = 'step', array $where = [], array $options = []): ?xPDOObject
    {
        $classKey = $this->classKeys[$className];
        $query = $this->getQuery($classKey, $where, array_merge($options, ['limit' => 1]));

        return $this->xpdo->getObject($classKey, $query);
    }

    public function getItems(string $className = 'step', array $where = [], array $options = [])
    {
        $classKey = $this->classKeys[$className];
        $query = $this->getQuery($classKey, $where, $options);

        return $this->xpdo->getCollection($classKey, $query);
    }

    public function getCount(string $className = 'step', array $where = []): int
    {
        $classKey = $this->classKeys[$className];
        return $this->xpdo->getCount($classKey, array_merge([
            'form_id' => $this->quiz_id ?: $this->id,
            'published' => 1,
        ], $where));
    }

    public function parseItems($items): array
    {
        foreach ($items as &$item) {
            $item->updateValues();
        }

        return $items;
    }

    public function copy(array $fields = [])
    {
        $newObject = $this->xpdo->newObject($this->_class);
        $newObject->fromArray($this->toArray(), '', false, true);
        foreach ($fields as $name => $value) {
            $newObject->set($name, $value);
        }
        if ($newObject->save()) {
            foreach ($this->_composites as $alias => $composite) {
                $this->copyItems($alias, [
                    $composite['foreign'] => $newObject->id
                ]);
            }

            return $newObject;
        }

        return null;
    }

    public function copyItems($alias, $fields): void
    {
        $items = $this->getMany($alias);
        foreach ($items as $item) {
            $item->copy($fields);
        }
    }
}