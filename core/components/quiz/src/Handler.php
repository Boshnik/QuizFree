<?php

namespace Boshnik\Quiz;

use Boshnik\Quiz\Traits\Query;
use Boshnik\Quiz\Traits\Helps;

class Handler
{
    use Query;
    use Helps;

    public $quiz;
    public Parse $chunk;
    public Response $response;
    public Validator $validator;
    public Form $form;

    public array $classKeys = [
        'form' => \QuizForm::class,
        'step' => \QuizStep::class,
        'field' => \QuizField::class,
        'value' => \QuizFieldValue::class,
        'result' => \QuizResult::class,
    ];

    function __construct(public \modX $modx, array $request = [], array $files = [])
    {
        $this->validator = new Validator($this->modx, [...$request, ...$files]);
        $this->response = new Response($this->validator);

        $action = $request['action'] ?? null;
        if ($action === 'step' || $action === 'submit') {
            $this->form = new Form($this->modx, $request);
        }

        $uuid = $request['quiz_id'] ?? null;
        $this->quiz = $this->modx->getObject($this->classKeys['form'], ['uuid' => $uuid]);
        if ($this->quiz) {
            $this->chunk = new Parse($this->modx, $this->quiz);
        }
    }

    /**
     * Get response based on the request action
     * @param array $request
     * @return array
     */
    public function getResponse(array $request, array $files = []): array
    {
        if (!$this->quiz) {
            return $this->response->failure('Quiz not found');
        }

        return match ($request['action']) {
            'total' => $this->handleTotalAction($request),
            'step' => $this->handleStepAction($request, $files),
            'submit' => $this->submit($request, $files),
            default => $this->response->failure('Action not allowed'),
        };
    }

    /**
     * @param array $request
     * @return array
     */
    public function handleTotalAction(array $request): array
    {
        $this->setResponseTotal($request);
        return $this->response->success();
    }

    /**
     * Handle step action
     * @param array $request
     * @return array
     */
    private function handleStepAction(array $request, array $files = []): array
    {
        $rules = $this->getRulesStep($request);
        if (isset($request['offset']) && $this->validator->validate($rules)) {
            if ($request['offset'] === $request['total']) {
                if ($this->quiz->contactform) {
                    return $this->getContactForm($request);
                } else {
                    return $this->submit($request, $files);
                }
            }
            return $this->getStep($request, $files);
        }

        return $this->response->failure();
    }

    /**
     * Get total steps count for the quiz
     * @param array $request
     */
    public function getTotal(array $request)
    {
        return $this->quiz->getCount('step');
    }

    /**
     * @param array $request
     * @return void
     */
    public function setResponseTotal(array $request): void
    {
        $total = $this->getTotal($request);
        $this->response->total = $total;
    }

    /**
     * Get validation rules for a quiz step
     * @param array $request
     * @return array
     */
    public function getRulesStep(array $request): array
    {
        if (!$request['offset']) {
            return [];
        }

        if (!$step = $this->quiz->getCurrentStep($request)) {
            return ['step_id' => 'required'];
        }

        $fields = $step->getFields([
            'required' => 1,
        ]);

        return $this->getRules($fields);
    }

    /**
     * @param $fields
     * @return array
     */
    public function getRules($fields): array
    {
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field->name] = $field->required ? 'required' : '';
        }

        return $rules;
    }

    /**
     * Get quiz form
     * @param int $quiz_id
     * @return string
     */
    public function getForm(): string
    {
        $data = [
            'quiz_id' => $this->quiz->uuid,
            'cover' => '',
            'steps' => '',
            'prev' => $this->quiz->prev,
            'next' => $this->quiz->next,
            'submit' => $this->quiz->submit,
        ];

        if ($this->quiz->cover) {
            $data['cover'] = $this->chunk->cover();
        } else {
            $step = $this->getStep([
                'offset' => 0,
            ]);
            if ($step['success']) {
                $data['steps'] = $step['output']['step'];
            }
        }

        $data['action'] = $this->modx->resource->uri;
        $data['csrf_token'] = $_SESSION['csrf_token'];

        return $this->chunk->form($data);
    }

    /**
     * Get contact form
     * @param array $request
     * @return array
     */
    public function getContactForm(array $request): array
    {
        $form = $this->chunk->contact();
        $this->setResponseTotal($request);

        return $this->response->success('', ['step' => $form]);
    }

    /**
     * Get quiz step
     * @param array $request
     * @return array
     */
    public function getStep(array $request, array $files = []): array
    {
        if (!$step = $this->quiz->getNextStep($request)) {
            if ($this->quiz->contactform) {
                return $this->getContactForm($request);
            } else {
                return $this->submit($request, $files);
            }
        }

        $this->setResponseTotal($request);

        $data = $step->toArray();
        $fields = $step->getFields();
        $data['fields'] = $this->chunk->fields([
            'fields' => $this->collToArray($fields),
        ]);

        return $this->response->success('', [
            'step' => $this->chunk->step($data)
        ]);
    }

    public function submit($request, $files): array
    {
        // Validate steps
        $steps = $this->quiz->getSteps();
        $stepFields = [];
        foreach ($steps as $step) {
            $data = $request;
            $data['step_id'] = $step->id;
            $fields = $step->getFields();
            $rules = $this->getRules($fields);
            if (!$this->validator->validate($rules)) {
                return $this->response->failure();
            }
            $stepFields = [...$stepFields, ...$fields];
        }

        // Validate contactForm fields
        $contactFields = $this->quiz->getContactFields();
        $rules = $this->getRules($contactFields);
        if (!$this->validator->validate($rules)) {
            return $this->response->failure();
        }

        // Get result
        $result = $this->quiz->getResult();

        // Get values
        $fields = [...$stepFields, ...$contactFields];

        $stepFields = $this->quiz->getValues($stepFields, $request);
        $contactFields = $this->quiz->getValues($contactFields, $request);

        // Send email manager
        if ($this->quiz->email && !empty($this->quiz->emailto)) {
            $emails = explode(',', $this->quiz->emailto);
            $subject = $this->quiz->emailsubject;
            if ($this->quiz->emailusefieldforsubject && isset($request['subject'])) {
                $subject = $request['subject'];
            }
            $message = $this->chunk->emailManager([
                'fields' => $fields,
                'values' => $stepFields,
                'contacts' => $contactFields,
            ]);
            foreach ($emails as $email) {
                $this->form->sendEmail($email, $subject, $message, $files);
            }
        }

        // Send email user
        if ($this->quiz->autoresponder && isset($request[$this->quiz->fiartofield])) {
            $email = $request[$this->quiz->fiartofield];
            $subject = $this->quiz->fiarsubject;
            $message = $this->chunk->emailUser([
                'fields' => $fields,
                'values' => $stepFields,
                'contacts' => $contactFields,
            ]);
            $this->form->sendEmail($email, $subject, $message, $files);
        }

        // Result
        if ($result) {
            switch ($result->type) {
                case 'redirect':
                    return $this->response->success('', ['redirect' => $result->getRedirectUrl()]);
                case 'content':
                    $content = $this->chunk->result($result->getContent($request));
                    return $this->response->success('', ['content' => $content]);
                default:
                    return $this->response->failure($this->quiz->error);
            }
        }

        return $this->response->success();
    }

}