<?php
declare(strict_types=1);

namespace App\Controller\Admin;
use App\Controller\AppController;
use App\Model\Entity\OrderDetail;
use App\Model\Entity\Product;
use App\Model\Entity\ProductInventory;
use Cake\I18n\FrozenTime;

/**
 * ProductInventories Controller
 *
 * @property \App\Model\Table\ProductInventoriesTable $ProductInventories
 * @method \App\Model\Entity\ProductInventory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductInventoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate += [
            'contain' => ['Products'],
        ];
        $searchParam = $this->request->getData();
        $productInventories = $this->ProductInventories
        ->find('search', ['search' => $searchParam])
        ->order(['product_id', 'date' => 'DESC']);
        $productInventories = $this->paginate($productInventories);

        $this->set(compact('productInventories', 'searchParam'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Inventory id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productInventory = $this->ProductInventories->get($id, [
            'contain' => ['Products'],
        ]);

        $this->set(compact('productInventory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productInventory = $this->ProductInventories->newEmptyEntity();
        if ($this->request->is('post')) {
            $productInventory = $this->ProductInventories->patchEntity($productInventory, $this->request->getData());
            if ($this->ProductInventories->save($productInventory)) {
                $this->Flash->success(__('The product inventory has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $error = $productInventory->getErrors();
                var_dump($error);
                // $this->Flash->error(__('The product inventory could not be saved. Please, try again.'));
            }

        }
        $products = $this->ProductInventories->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('productInventory', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Inventory id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productInventory = $this->ProductInventories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();
            $requestData['date'] = FrozenTime::parse($requestData['date'] . FrozenTime::now()->i18nFormat(' HH:mm:ss'));
            $productInventory = $this->ProductInventories->patchEntity($productInventory, $requestData);
            if ($this->ProductInventories->save($productInventory)) {
                $this->Flash->success(__('The product inventory has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product inventory could not be saved. Please, try again.'));
        }
        $products = $this->ProductInventories->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('productInventory', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Inventory id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productInventory = $this->ProductInventories->get($id);
        if ($this->ProductInventories->delete($productInventory)) {
            $this->Flash->success(__('The product inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The product inventory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function stock() {
        $searchParam = $this->request->getData();
        $categories = $this->ProductInventories->Products->Categories->find()->all()
            ->combine('id', 'name')
            ->toArray();
        $categories = ['All'] + $categories;

        $products = $this->ProductInventories->Products->find()->all()
            ->combine('id', 'name')
            ->toArray();
        $products = ['All'] + $products;

        // 販売済み品数を取得
        $solds = $this->ProductInventories->Products->OrderDetails->find();
        $solds = $solds
            ->select([
                'OrderDetails.product_id',
                'sum' => $solds->func()->sum('quantity')
            ])
            ->group('OrderDetails.product_id')
            ->all()
            ->combine('product_id', function(OrderDetail $orderDetail) {
                return $orderDetail;
            })
            ->toArray();
            // var_dump($sold);

        // 購入した品数を取得
        $inventories = $this->ProductInventories->find('search', ['search' => $searchParam]);
        $inventories = $inventories
            ->select([
                'ProductInventories.product_id',
                'sum' => $inventories->func()->sum('quantity')
            ])
            ->group('ProductInventories.product_id')
            ->contain('Products')
            ->all()
            ->map(function(ProductInventory $productInventory) use($solds) {
                if(isset($sold[$productInventory->product_id])) {
                    $productInventory['sold'] = $solds[$productInventory->product_id]->sum;
                }
                return $productInventory;
            })
            ->toArray();
            // var_dump($inventories);
        $this->set(compact('categories', 'products', 'inventories'));
    }
}
