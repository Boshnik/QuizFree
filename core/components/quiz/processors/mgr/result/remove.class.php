<?php

class QuizResultRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
    public $languageTopics = ['quiz'];

}

return 'QuizResultRemoveProcessor';