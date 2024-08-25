<?php

class QuizFormRemoveProcessor extends modObjectRemoveProcessor
{
    public $classKey = QuizForm::class;
    public $objectType = 'quiz_object';
    public $languageTopics = ['quiz'];

}

return 'QuizFormRemoveProcessor';