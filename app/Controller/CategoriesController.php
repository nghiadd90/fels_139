<?php
class CategoriesController extends AppController
{
    public $components = ['Paginator'];

    public $helpers = ['Html', 'Form', 'Session'];

    public $uses = ['Category', 'Word', 'WordAnswer', 'Lesson', 'LessonWord', 'User'];

    public function index()
    {
        $categories = $this->Paginator->paginate('Category');
        $categoryWords = $this->Category->totalWordsInCategory();
        $learnedWords = $this->Category->totalLearnedWordsInCategory();
        $this->set([
            'categories' => $this->Paginator->paginate('Category'),
            'categoryWords' => $categoryWords,
            'learnedWords' => $learnedWords
        ]);
    }

    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid category'));
        }

        $category = $this->Category->findById($id);
        if (!$category) {
            throw new NotFoundException(__('Invalid category'));
        }
        $this->Category->Word->recursive = -1;

        return $this->set([
            'category' => $category,
            'words' => $this->Category->Word->find('all', [
                'conditions' => [
                    'Word.category_id' => $id
                ]
            ])
        ]);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Category->create();

            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('The category has been saved.'), 'success');

                return $this->redirect(['action' => 'index']);
            }

            $this->Session->setFlash(__('The category could not saved'), 'error');
        }
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid category'));
        }

        $category = $this->Category->findById($id);
        if (!$category) {
            throw new NotFoundException(__('Invalid category'));
        }

        if ($this->request->is(['post', 'put'])) {
            $this->Category->id = $id;

            if ($this->Category->save($this->request->data)) {
                $this->Session->setFlash(__('This category has been saved'), 'success');

                return $this->redirect(['action' => 'index']);
            }

            $this->Session->setFlash(__('Unalbe update your category'), 'error');
        }

        if (!$this->request->data) {
            $this->request->data = $category;
        }
    }

    public function delete($id = null)
    {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Category->delete($id)) {
            $this->Session->setFlash(
                __('The category with id: %s has been deleted.', h($id)),
                'success'
            );
        } else {
            $this->Session->setFlash(
                __('The category with id: %s could not be deleted', h($id)),
                'error'
            );
        }

        return $this->redirect(['action' => 'index']);
    }

    public function learn($id = null)
    {
        $this->request->onlyAllow('post');

        if (!$this->Category->exists($id)) {
            throw new NotFoundException(__('Invalid category'));
        }

        return $this->redirect([
            'controller' => 'lessons',
            'action' => 'learn',
            $id
        ]);
    }
}
