<?php

class QuizFormGetProcessor extends modObjectGetProcessor
{
    public $classKey = QuizForm::class;
    public $objectType = 'quiz_object';
    public $languageTopics = ['quiz:default'];

}

return 'QuizFormGetProcessor';