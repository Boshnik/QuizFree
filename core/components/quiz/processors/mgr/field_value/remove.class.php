<?php

class QuizFieldValueRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizFieldValue::class;
    public $languageTopics = ['quiz'];

}

return 'QuizFieldValueRemoveProcessor';