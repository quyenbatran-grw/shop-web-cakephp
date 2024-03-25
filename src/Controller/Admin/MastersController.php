<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Table\MastersTable;

/**
 * Masters Controller
 *
 * @property \App\Model\Table\MastersTable $Masters
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MastersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $masters = $this->Masters->find()->order(['type' => 'ASC', 'ranking' => 'ASC'])->all();
        $types = MastersTable::$types;
        $mode = $this->request->getQuery('q', 0);

        $this->set(compact('masters', 'types', 'mode'));
    }

    /**
     * View method
     *
     * @param string|null $id Master id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $master = $this->Masters->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('master'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($type)
    {
        $this->viewBuilder()->setClassName('Json');
        $master = $this->Masters->newEmptyEntity();
        $errors = [];
        $redirect = null;
        if ($this->request->is('post')) {
            $master = $this->Masters->patchEntity($master, $this->request->getData());
            $master->set('type', intval($type));
            // $master->parent_id = null;
            $max_rank = $this->Masters->find()->where(['type' => $type])->max('ranking');
            // $max_rank = $max_rank->select(['ranking'])->max('ranking');
            if(empty($max_rank)) {
                $master->set('ranking', 1);
            } else {
                // $max_rank = $master->max('ranking');
                $master->set('ranking', $max_rank['ranking'] + 1);
            }
            if ($this->Masters->save($master)) {
                // $this->Flash->success(__('The master has been saved.'));
                $redirect = '/admin/masters/?q=' . $type;
                // return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The master could not be saved. Please, try again.'));
        }
        $this->set(compact('master', 'errors', 'redirect'));
        $this->viewBuilder()->setOption('serialize', ['master', 'errors', 'redirect']);
    }

    /**
     * Edit method
     *
     * @param int|null $id Master id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setClassName('Json');
        $errors = [];
        $redirect = null;
        $master = $this->Masters->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            // // 更新
            // $max_rank = $this->Masters->find();
            // $max_rank = $max_rank->select(['ranking'])->max('ranking');
            // if(empty($max_rank)) {
            //     $max_rank = 1;
            // } else {
            //     $max_rank = $max_rank['ranking'] + 1;
            // }
            $master = $this->Masters->patchEntity($master, $this->request->getData());
            if(!empty($master)) {
                if ($this->Masters->save($master)) {
                    $redirect = '/admin/masters/?q=' . $master->type;
                } else {
                    $errors = $master->getErrors();
                }
            }
        }
        $this->set(compact('master', 'errors', 'redirect'));
        $this->viewBuilder()->setOption('serialize', ['master', 'errors', 'redirect']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Master id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $master = $this->Masters->get($id);
        if ($this->Masters->delete($master)) {
            $this->Flash->success(__('The master has been deleted.'));
        } else {
            $this->Flash->error(__('The master could not be deleted. Please, try again.'));
        }

        if(!empty($master)) {
            return $this->redirect('/admin/masters/?q='.$master->type);
        }
        return $this->redirect('/admin/masters/');
    }

    /**
     * Move up
     * 
     * @param int|null $id
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function moveUp($id = null) {
        $master = $this->Masters->find()->where(['id' => $id])->first();
        if(empty($master)) {
            throw new RecordNotFoundException("Error Processing Request", 1);
            
        }
        $master->parent_id = null;
        $this->Masters->moveUp($master);
        return $this->redirect('/admin/masters/?q='.$master->type);
    }

    /**
     * Move up
     * 
     * @param int|null $id
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function moveDown($id = null) {
        $master = $this->Masters->find()->where(['id' => $id])->first();
        if(empty($master)) {
            throw new RecordNotFoundException("Error Processing Request", 1);
            
        }
        $master->parent_id = null;
        $this->Masters->moveDown($master);
        return $this->redirect('/admin/masters/?q='.$master->type);
    }
}
