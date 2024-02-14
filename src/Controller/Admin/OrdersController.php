<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Order;
use App\Model\Table\OrdersTable;
use Cake\I18n\Number;
use Cake\ORM\Query;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $searchParam = $this->request->getData();
        $orders = $this->Orders->find('search', ['search' => $searchParam])
            ->order(['status' => 'ASC', 'immediate' => 'DESC', 'created' => 'ASC']);
        $orders = $this->paginate($orders);

        $this->set(compact('orders', 'searchParam'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['OrderDetails' => function(Query $query) {
                return $query->contain('Products');
            }],
        ]);

        $status_list = OrdersTable::$statusList;

        $this->set(compact('order', 'status_list'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $status_list = OrdersTable::$statusList;
        $this->set(compact('order', 'status_list'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $this->set(compact('order'));
    }

    public function updateStatus($id) {
        $order = $this->Orders->find()->where(['id' => $id])->firstOrFail();
        if(!empty($order)) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if($this->Orders->save($order)) {
                if($order->status == OrdersTable::DELIVERED) {
                    // ポイント計算
                    $amount = $order->order_amount;
                    $point = floor($amount / 100000);
                    $user = $this->Orders->Users->find()
                        ->where(['id' => $order->user_id])
                        ->firstOrFail();
                    if(!empty($user->point)) $point = $point + intval($user->point);
                    $user->set('point', $point);
                    $this->Orders->Users->save($user);
                    exit();
                }
                $this->Flash->success(__('The order has been updated.'));
            } else {
                $this->Flash->error(__('The order count not be saved.'));
            }
        }
        $this->redirect(['action' => 'view', $id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
