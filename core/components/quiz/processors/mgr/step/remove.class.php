<?php

class QuizStepRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizStep::class;
    public $languageTopics = ['quiz'];

}

return 'QuizStepRemoveProcessor';