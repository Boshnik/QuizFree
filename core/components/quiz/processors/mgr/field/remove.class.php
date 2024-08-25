<?php

class QuizFieldRemoveProcessor extends modObjectRemoveProcessor
{
    public $objectType = 'quiz_object';
    public $classKey = QuizField::class;
    public $languageTopics = ['quiz'];

}

return 'QuizFieldRemoveProcessor';