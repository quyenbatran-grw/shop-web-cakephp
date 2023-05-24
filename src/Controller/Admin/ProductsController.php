<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Laminas\Diactoros\UploadedFile;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $products = $this->paginate($this->Products);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => ['Categories', 'ImageProducts'],
        ]);

        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $requestData = $this->request->getData();
            // var_dump($requestData);
            $image_products = $requestData['image_products'];
            $save_images = [];
            if($image_products && count($image_products)) {
                foreach ($image_products as $key => $image_product) {
                    $filepath = WWW_ROOT.'/img/products/';
                    do {
                        $files = scandir($filepath);
                        $filename = md5(uniqid()) . '.jpg';
                        if(!in_array($filename, $files)) {
                            $save_images[$filename] = [
                                'name' => $image_product->getClientFilename(),
                                'file_name' => $filename,
                                'file_size' => $image_product->getSize(),
                                'file_type' => $image_product->getClientMediaType()
                            ];
                            $image_products[$key] = new UploadedFile($image_product->getStream(), $image_product->getSize(), 0, $filename);
                            break;
                        }
                    } while (true);

                }
            }
            $requestData['image_products'] = $save_images;
            $product = $this->Products->patchEntity($product, $requestData, ['associated' => ['ImageProducts']]);
            // dd($image_products);
            // dd($this->request->getData());
            // dd($product);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                if($image_products && count($image_products)) {
                    if(!file_exists(WWW_ROOT.'/img/products')) mkdir(WWW_ROOT.'/img/products', 0777);
                    foreach ($image_products as $image_product) {
                        $image_product->moveTo(WWW_ROOT.'/img/products/'.$image_product->getClientFilename());
                    }
                }
                // dd($image_products);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('product', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('product', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
