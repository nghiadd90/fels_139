<?php
App::uses('Component', 'Controller');

class WordFilterComponent extends Component
{
    public $components = ['Auth'];


    public function filterWords($category_id, $filter)
    {
        $wordModel = ClassRegistry::init('Word');
        $userModel = ClassRegistry::init('User');
        $wordModel->recursive = -1;
        switch ($filter) {
            case 'all':
                if ($category_id == null) {
                    return $wordModel->find('all');
                }

                return $wordModel->find('all', ['conditions' => ['category_id' => 4]]);

            case 'learned':
                $learnedWordList = $userModel->learnedWordList($category_id);

                return $wordModel->find('all', [
                    'conditions' => [
                        'Word.id' => array_keys($learnedWordList)
                    ]
                ]);

            case 'notlearned':
                $notLearnedWordList = $userModel->notLearnedWordList($category_id);

                return $wordModel->find('all', [
                    'conditions' => [
                        'Word.id' => array_keys($notLearnedWordList)
                    ]
                ]);

            default:
                throw new NotFoundException(__('Invalid parameter'));
        }
    }
}
