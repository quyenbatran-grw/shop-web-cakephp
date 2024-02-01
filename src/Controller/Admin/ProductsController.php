<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Laminas\Diactoros\UploadedFile;
use Cake\I18n\Time;

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
        $this->paginate += [
            'contain' => ['Categories'],
        ];
        $products = $this->Products->find('valid');
        $products = $this->paginate($products);

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
        $errors = [];
        if ($this->request->is('post')) {
            $this->viewBuilder()->setClassName('Json');
            $product = null;
            $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
            $requestData = $this->request->getData();
            $image_products = $this->request->getData('save_images', []);
            // var_dump($image_products);
            $save_images = [];
            foreach ($image_products as $key => $image_product) {
                $filepath = WWW_ROOT.'/img/products/';
                // var_dump($image_product);
                do {
                    $files = scandir($filepath);
                    $filetype = $image_product->getClientMediaType();
                    $filetype = str_replace('image/', '', $filetype);
                    $filetype = 'png';
                    $filename = md5(uniqid()) . '.' . $filetype;
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
            $requestData['image_products'] = $save_images;
            $product = $this->Products->newEmptyEntity();
            $product = $this->Products->patchEntity($product, $requestData, ['associated' => ['ImageProducts']]);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                if($image_products && count($image_products)) {
                    if(!file_exists(WWW_ROOT.'/img/products')) mkdir(WWW_ROOT.'/img/products', 0777);
                    foreach ($image_products as $image_product) {
                        $image_product->moveTo(WWW_ROOT.'/img/products/'.$image_product->getClientFilename());
                    }
                }
            } else {
                $errors = $product->getErrors();
            }
            $redirect = '/admin/products/';
            $this->set(compact('product', 'categories', 'image_products', 'errors', 'redirect'));
            $this->viewBuilder()->setOption('serialize', ['product', 'categories', 'image_products', 'errors', 'redirect']);
        } else if ($this->request->is('get')) {
            $product = $this->Products->newEmptyEntity();
            $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
            $this->set(compact('product', 'categories', 'errors'));
        }
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
            'contain' => ['ImageProducts'],
        ]);
        $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->viewBuilder()->setClassName('Json');
            $errors = [];
            $requestData = $this->request->getData();
            $image_products = $this->request->getData('save_images', []);
            $delete_images = $this->request->getData('deleted_img', '');
            // var_dump($image_products);
            $save_images = [];
            foreach ($image_products as $key => $image_product) {
                $filepath = WWW_ROOT.'/img/products/';
                // var_dump($image_product);
                do {
                    $files = scandir($filepath);
                    $filetype = $image_product->getClientMediaType();
                    $filetype = str_replace('image/', '', $filetype);
                    $filetype = 'png';
                    $filename = md5(uniqid()) . '.' . $filetype;
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
            $requestData['image_products'] = $save_images;


            $product = $this->Products->patchEntity($product, $requestData);
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));
                if($delete_images != '') {
                    $delete_images = explode(',', $delete_images);
                    $this->Products->ImageProducts->deleteAll(['id IN' => $delete_images]);
                }
                if($image_products && count($image_products)) {
                    if(!file_exists(WWW_ROOT.'/img/products')) mkdir(WWW_ROOT.'/img/products', 0777);
                    foreach ($image_products as $image_product) {
                        $image_product->moveTo(WWW_ROOT.'/img/products/'.$image_product->getClientFilename());
                    }
                }
            } else {
                $errors = $product->getErrors();
            }
            $redirect = '/admin/products/';
            $this->set(compact('product', 'categories', 'image_products', 'errors', 'redirect'));
            $this->viewBuilder()->setOption('serialize', ['product', 'categories', 'image_products', 'errors', 'redirect']);
        } else {
            $this->set(compact('product', 'categories'));
        }

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
        $product->set('deleted', FrozenTime::now());
        if ($this->Products->save($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
