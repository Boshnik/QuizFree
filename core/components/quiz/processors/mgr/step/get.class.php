<?php

class QuizStepGetProcessor extends modObjectGetProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizStep::class;
    public $languageTopics = ['quiz'];

}

return 'QuizStepGetProcessor';