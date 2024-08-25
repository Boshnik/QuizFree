<?php

class QuizFieldValueGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
    public $languageTopics = ['quiz'];

}

return 'QuizFieldValueGetProcessor';