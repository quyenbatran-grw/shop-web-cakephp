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
        // $orders = [];
        // if(isset($queryParams['sort'])) {
        //     $orders[$queryParams['sort']] = isset($queryParams['direction']) ? $queryParams['direction'] : 'ASC';
        // } else {
        //     $orders = ['type' => 'ASC', 'rank' => 'ASC'];
        // }
        $masters = $this->Masters->find();
                        // ->order($orders);
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
     * @param string|null $type Master id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($type = null, $id = null)
    {
        $this->viewBuilder()->setClassName('Json');
        $master = null;
        $errors = [];
        $redirect = null;
        if(!is_null($id)) {
            $master = $this->Masters->get($id, [
                'contain' => [],
            ]);
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(is_null($id)) {
                // 新規登録
                if(is_null($type)) {
                    $errors[] = ['name' => MSG_2000];
                } else {
                    $master = $this->Masters->newEmptyEntity();
                    $master = $this->Masters->patchEntity($master,$this->request->getData());
                    $max_rank = $this->Masters->find();
                    $max_rank = $max_rank->select(['rank'])->max('rank');
                    if(empty($max_rank)) {
                        $master->set('rank', 1);
                    } else {
                        $master->set('rank', $max_rank['max_rank']);
                    }
                    $master->set('type', intval($type));
                }
            } else {
                // 更新
                $max_rank = $this->Masters->find();
                $max_rank = $max_rank->select(['rank'])->max('rank');
                if(empty($max_rank)) {
                    $max_rank = 1;
                } else {
                    $max_rank = $max_rank['max_rank'] + 1;
                }
                $master = $this->Masters->patchEntity($master, $this->request->getData())->set('rank', $max_rank);
            }
            if(!empty($master)) {
                if ($this->Masters->save($master)) {
                //     $this->Flash->success(__('The master has been saved.'));
                    $redirect = '/admin/products/';
                    // $this->set(compact('redirect'));
                //     return $this->redirect(['action' => 'index']);
                } else {
                    $errors = $master->getErrors();
                }
            }
            // $master = $this->Masters->patchEntity($master, $this->request->getData());
            
            // $this->Flash->error(__('The master could not be saved. Please, try again.'));
        }
        $this->set(compact('master', 'errors', 'redirect'));
        $this->viewBuilder()->setOption('serialize', ['master', 'errors']);
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