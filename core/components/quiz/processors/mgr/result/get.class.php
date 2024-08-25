<?php

class QuizResultGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizResult::class;
    public $languageTopics = ['quiz'];

}

return 'QuizResultGetProcessor';