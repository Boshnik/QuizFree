<?php

class QuizStepGetListProcessor extends modObjectGetListProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizStep::class;


    /**
     * @param xPDOQuery $c
     *
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c->where([
            'form_id' => $this->properties['form_id'] ?? 0,
        ]);

        if (isset($this->properties['published'])) {
            $c->where([
                'published' => 1
            ]);
        }

        return $c;
    }


    /**
     * @param xPDOObject $object
     *
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $array = $object->toArray();
        $array['actions'] = [];

        // Edit
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-edit',
            'title' => $this->modx->lexicon('quiz_row_update'),
            'action' => 'updateObject',
            'button' => true,
            'menu' => true,
        ];

        // Copy
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-copy',
            'title' => $this->modx->lexicon('quiz_row_copy'),
            'action' => 'copyObject',
            'button' => true,
            'menu' => true,
        ];

        if (!$array['published']) {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-green',
                'title' => $this->modx->lexicon('quiz_row_enable'),
                'multiple' => $this->modx->lexicon('quiz_rows_enable'),
                'action' => 'enableObject',
                'button' => true,
                'menu' => true,
            ];
        } else {
            $array['actions'][] = [
                'cls' => '',
                'icon' => 'icon icon-power-off action-gray',
                'title' => $this->modx->lexicon('quiz_row_disable'),
                'multiple' => $this->modx->lexicon('quiz_rows_disable'),
                'action' => 'disableObject',
                'button' => true,
                'menu' => true,
            ];
        }

        // Remove
        $array['actions'][] = [
            'cls' => '',
            'icon' => 'icon icon-trash-o action-red',
            'title' => $this->modx->lexicon('quiz_row_remove'),
            'multiple' => $this->modx->lexicon('quiz_rows_remove'),
            'action' => 'removeObject',
            'button' => true,
            'menu' => true,
        ];

        return $array;
    }

}

return 'QuizStepGetListProcessor';