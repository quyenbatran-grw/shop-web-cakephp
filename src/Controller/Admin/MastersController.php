<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

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
        $queryParams = $this->request->getQueryParams();
        $orders = [];
        if(isset($queryParams['sort'])) {
            $orders[$queryParams['sort']] = isset($queryParams['direction']) ? $queryParams['direction'] : 'ASC';
        } else {
            $orders = ['type' => 'ASC', 'rank' => 'ASC'];
        }
        $masters = $this->Masters->find()
                        ->order($orders);
        $masters = $this->paginate($masters);

        $this->set(compact('masters'));
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
    public function add()
    {
        $master = $this->Masters->newEmptyEntity();
        if ($this->request->is('post')) {
            $master = $this->Masters->patchEntity($master, $this->request->getData());
            // 種別毎に並び順の最大値を取得する
            $type = $this->request->getData('type');
            $max_rank_q = $this->Masters->find('byType', ['type' => $type]);
            $max_rank_q = $max_rank_q->select(['rank' => $max_rank_q->func()->max('rank')])->firstOrFail();
            $max_rank = $max_rank_q && $max_rank_q->rank ? $max_rank_q->rank : 0;
            $master->set('rank', $max_rank + 1);
            //
            if ($this->Masters->save($master)) {
                $this->Flash->success(__('The master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master could not be saved. Please, try again.'));
        }
        $this->set(compact('master'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Master id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $master = $this->Masters->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $master = $this->Masters->patchEntity($master, $this->request->getData());
            if ($this->Masters->save($master)) {
                $this->Flash->success(__('The master has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The master could not be saved. Please, try again.'));
        }
        $this->set(compact('master'));
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

        return $this->redirect(['action' => 'index']);
    }
}
