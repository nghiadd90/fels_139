<?php
class LessonsController extends AppController
{
    public $components = ['Paginator'];

    public $helpers = ['Html', 'Form', 'Session'];

    public $uses = ['Category', 'Word', 'Lesson', 'LessonWord', 'User', 'Activity'];

    public function index()
    {
        $this->Lesson->recursive = 1;

        $lessons = $this->Lesson->find('all', [
            'conditions' => [
                'Lesson.user_id' => $this->Auth->user('id')
            ]
        ]);
        $this->set('lessons', $lessons);
    }

    public function learn($category_id = null)
    {
        if (!$this->Category->exists($category_id)) {
            throw new NotFoundException(__('Invalid category'));
        }

        if ($this->request->is('post')) {
            // check result of lesson
            $result = 0;
            foreach ($this->request->data['LessonWord'] as $lessonWord) {
                $result += $this->Word->isCorrect((int)$lessonWord['word_id'], (int)$lessonWord['word_answer_id'])? 1 : 0;
            }

            $this->request->data['Lesson']['user_id'] = $this->Auth->user('id');
            $this->request->data['Lesson']['result'] = $result;

            $this->Lesson->create();
            if ($this->Lesson->saveAssociated($this->request->data)) {
                // insert action into activities table
                $this->request->data['Activity'] = [
                    'target_id' => $this->Lesson->id,
                    'user_id' => $this->Auth->user('id'),
                    'action_type' => 'learn'
                ];

                if ($this->Activity->save($this->request->data)) {
                    $this->Session->setFlash(__('You just finished one lesson. Success update your activity'), 'success');

                    return $this->redirect('/');
                }
            }

            $this->Session->setFlash(__(ERROR_MSG), 'error');
        }

        if (!$this->request->data) {
            $wordList = $this->User->wordsForLesson($category_id);
            $this->set([
                'wordList' => $wordList,
                'category' => $this->Category->findById($category_id)
            ]);
        }
    }

    public function result($id = null)
    {
        $this->Lesson->recursive = -1;
        $lesson = $this->Lesson->findById($id);
        if (!$lesson) {
            throw new NotFoundException(__('Invalid lesson'));
        }

        if ($this->Auth->user('id') != $lesson['Lesson']['user_id']) {
            $this->Session->setFlash(__('You do not have permission to access this page'), 'error');
            return $this->redirect('/');
        }

        $options = [
            'joins' => [
                [
                    'table' => 'lesson_words',
                    'alias' => 'lw',
                    'type' => 'inner',
                    'conditions' => ['Lesson.id = lw.lesson_id']
                ],
                [
                    'table' => 'words',
                    'alias' => 'w',
                    'type' => 'inner',
                    'conditions' => ['w.id = lw.word_id']
                ],
                [
                    'table' => 'word_answers',
                    'alias' => 'wa',
                    'type' => 'inner',
                    'conditions' => ['wa.id = lw.word_answer_id']
                ],
                [
                    'table' => 'categories',
                    'alias' => 'ct',
                    'type' => 'inner',
                    'conditions' => ['Lesson.category_id = ct.id']
                ]
            ],
            'conditions' => [
                'Lesson.id' => $id
            ],
            'fields' => [
                'w.id',
                'w.content',
                'wa.content',
                'wa.id',
                'wa.correct',
                'Lesson.result',
                'ct.name'
            ]
        ];

        $lessonResult = $this->Lesson->find('all', $options);

        $this->set('lessonResult', $lessonResult);
    }
}
