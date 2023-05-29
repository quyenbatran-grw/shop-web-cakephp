<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ShoppingCarts Controller
 *
 * @property \App\Model\Table\ShoppingCartsTable $ShoppingCarts
 * @method \App\Model\Entity\ShoppingCart[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShoppingCartsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'DeviceTokens', 'Categories', 'Products'],
        ];
        $shoppingCarts = $this->paginate($this->ShoppingCarts);

        $this->set(compact('shoppingCarts'));
    }

    /**
     * View method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shoppingCart = $this->ShoppingCarts->get($id, [
            'contain' => ['Users', 'DeviceTokens', 'Categories', 'Products'],
        ]);

        $this->set(compact('shoppingCart'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shoppingCart = $this->ShoppingCarts->newEmptyEntity();
        if ($this->request->is('post')) {
            $shoppingCart = $this->ShoppingCarts->patchEntity($shoppingCart, $this->request->getData());
            if ($this->ShoppingCarts->save($shoppingCart)) {
                $this->Flash->success(__('The shopping cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shopping cart could not be saved. Please, try again.'));
        }
        $users = $this->ShoppingCarts->Users->find('list', ['limit' => 200])->all();
        $deviceTokens = $this->ShoppingCarts->DeviceTokens->find('list', ['limit' => 200])->all();
        $categories = $this->ShoppingCarts->Categories->find('list', ['limit' => 200])->all();
        $products = $this->ShoppingCarts->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('shoppingCart', 'users', 'deviceTokens', 'categories', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shoppingCart = $this->ShoppingCarts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shoppingCart = $this->ShoppingCarts->patchEntity($shoppingCart, $this->request->getData());
            if ($this->ShoppingCarts->save($shoppingCart)) {
                $this->Flash->success(__('The shopping cart has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shopping cart could not be saved. Please, try again.'));
        }
        $users = $this->ShoppingCarts->Users->find('list', ['limit' => 200])->all();
        $deviceTokens = $this->ShoppingCarts->DeviceTokens->find('list', ['limit' => 200])->all();
        $categories = $this->ShoppingCarts->Categories->find('list', ['limit' => 200])->all();
        $products = $this->ShoppingCarts->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('shoppingCart', 'users', 'deviceTokens', 'categories', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shopping Cart id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shoppingCart = $this->ShoppingCarts->get($id);
        if ($this->ShoppingCarts->delete($shoppingCart)) {
            $this->Flash->success(__('The shopping cart has been deleted.'));
        } else {
            $this->Flash->error(__('The shopping cart could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
