<?php

require_once __DIR__ . '/xpdoquizobject.php';
class QuizResult extends xPDOQuizObject
{
    public string $objectKeyField = 'result_id';

    public function getRedirectUrl(): string
    {
        $redirectParams = !empty($this->redirectrarams)
            ? json_decode($this->redirectrarams, true)
            : '';

        return $this->xpdo->makeUrl($this->redirectto, '', $redirectParams, 'full');
    }

    public function getContent(array $request = []): array
    {
        $quiz = $this->getOne('Form');
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'content' => $this->content,
            'values' => $quiz->getStepsValues($request),
            'contacts' => $quiz->getContactValues($request),
            'reset' => $quiz->reset,
            'points' => $request['points'] ?? 0,
            'score' => $request['score'] ?? 0,
        ];
    }
}