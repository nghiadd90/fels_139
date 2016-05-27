<?php
class WordsController extends AppController
{
    public $components = ['Paginator'];

    public $helpers = ['Html', 'Form', 'Session'];

    public function index()
    {
        return $this->set('words', $this->Paginator->paginate('Word'));
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Word'));
        }

        $word = $this->Word->findById($id);
        if (!$word) {
            throw new NotFoundException(__('Invalid Word'));
        }

        return $this->set('word', $word);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Word->create();
            if ($this->Word->saveAssociated($this->request->data)) {
                $this->Session->setFlash(__('The Word has been saved.'), 'success');

                return $this->redirect(['action' => 'index']);
            }
            $this->Session->setFlash(__('The Word could not saved'), 'error');
        }

        $categories = $this->Word->Category->find('list');
        $this->set(compact('categories'));
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid Word'));
        }

        $word = $this->Word->findById($id);
        if (!$word) {
            throw new NotFoundException(__('Invalid Word'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Word->id = $id;
            if ($this->Word->saveAll($this->request->data)) {
                $this->Session->setFlash(__('This Word has been saved'), 'success');

                return $this->redirect(['action' => 'index']);
            }

            $this->Session->setFlash(__('Unalbe update your Word'), 'error');
        }

        if (!$this->request->data) {
            $this->request->data = $word;
            $this->set('categories', $this->Word->Category->find('list'));
        }
    }

    public function delete($id = null)
    {
        $this->request->onlyAllow('post');

        if ($this->Word->delete($id)) {
            $this->Session->setFlash(
                __('The Word with id: %s has been deleted.', h($id)),
                'success'
            );

            if ($this->Word->WordAnswer->deleteAll(['word_id' => $id])) {
                $this->Session->setFlash(
                    __('The Word with id: %s has been deleted. And list of answer for this word has been deleted too.', h($id)),
                    'success'
                );
            } else {
                $this->Session->setFlash(
                    __('The Word with id: %s has been deleted. But list of answer for this word could not be deleted.', h($id)),
                    'error'
                );
            }
        } else {
            $this->Session->setFlash(
                __('The Word with id: %s could not be deleted', h($id)),
                'error'
            );
        }

        return $this->redirect(['action' => 'index']);
    }
}
