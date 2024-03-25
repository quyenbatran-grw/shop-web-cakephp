<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Order;
use App\Model\Entity\OrderDetail;
use App\Model\Entity\Product;
use App\Model\Entity\ProductInventory;
use App\Model\Table\MastersTable;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
    public function initialize(): void
    {
        parent::initialize();

        $this->Masters = $this->fetchTable('Masters');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // 提供者一覧
        $sponsors = $this->Masters
            ->find('byType', ['type' => MastersTable::SPONSOR])
            ->all()
            ->combine('id','name')
            ->toArray();
        $sponsors = array_merge(['Chọn nhà phân phối'], $sponsors);
        $this->paginate += [
            'contain' => ['Categories'],
        ];
        // 検索条件
        $searchParam = $this->request->getData();
        $products = $this->Products->find('search', ['search' => $searchParam])->find('valid')
            ->contain([
                'ProductInventories' => function($query) {
                    return $query->limit(1);
                }
            ]);
        $products = $this->paginate($products);

        // 入庫数
        $inventories = $this->_getStockProductQuantity($products->toArray());
        $categoryList = $this->Products->Categories->find()
            ->all()
            ->combine('id', 'name')
            ->toArray();
        $categoryList = ['All'] + $categoryList;

        $this->set(compact('products', 'categoryList', 'searchParam', 'inventories', 'sponsors'));
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
        $mades = $this->Masters
            ->find('byType', ['type' => MastersTable::MADE_IN])
            ->all()
            ->combine('id','name')
            ->toArray();
        $sponsors = $this->Masters
            ->find('byType', ['type' => MastersTable::SPONSOR])
            ->all()
            ->combine('id','name')
            ->toArray();
        $units = $this->Masters
            ->find('byType', ['type'=> MastersTable::UNIT])
            ->all()
            ->combine('id','name')
            ->toArray();
        if ($this->request->is('post')) {
            $this->viewBuilder()->setClassName('Json');
            $product = null;
            $categories = $this->Products->Categories->find('list', ['limit' => 200])->all()->toArray();
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
            $requestData['imported_quantity'] = $requestData['quantity'];
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
                $errors = (object)$product->getErrors();
            }
            $redirect = '/admin/products/';
            $this->set(compact('product', 'categories', 'image_products', 'errors', 'redirect', 'mades', 'sponsors', 'units'));
            $this->viewBuilder()->setOption('serialize', ['product', 'categories', 'image_products', 'errors', 'redirect', 'mades', 'sponsors', 'units']);
        } else if ($this->request->is('get')) {
            $product = $this->Products->newEmptyEntity();
            $categories = $this->Products->Categories->find('list', ['limit' => 200])->all();
            $this->set(compact('product', 'categories', 'errors', 'mades', 'sponsors', 'units'));
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
        $errors = [];
        $originals = $this->Masters
            ->find('byType', ['type' => MastersTable::MADE_IN])
            ->all()
            ->combine('id','name')
            ->toArray();
        $sponsors = $this->Masters
            ->find('byType', ['type' => MastersTable::SPONSOR])
            ->all()
            ->combine('id','name')
            ->toArray();
        $units = $this->Masters
            ->find('byType', ['type'=> MastersTable::UNIT])
            ->all()
            ->combine('id','name')
            ->toArray();
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
            $requestData['imported_quantity'] = $product->imported_quantity + (int)$requestData['quantity'] - $product->quantity;
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
            $this->set(compact('product', 'categories', 'image_products', 'errors', 'redirect', 'originals', 'sponsors', 'units'));
            $this->viewBuilder()->setOption('serialize', ['product', 'categories', 'image_products', 'errors', 'redirect']);
        } else {
            $this->set(compact('product', 'categories', 'originals', 'sponsors', 'units'));
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

    /**
     * ファイルから一括データをインポートする
     * 
     * @return Json
     */
    public function importProduct() {
        $this->request->allowMethod(['post']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $errors = [];
            $redirect = '/admin/products/';
            $importFile = isset($_FILES['import-product']) ? $_FILES['import-product'] : null;
            if ($importFile) {
                $spreadsheet = IOFactory::load($importFile['tmp_name']);
                $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true);
                $index = 1;
                $entities = [];
                foreach ($sheetData as $key => $row) {
                    if ($key == 0) continue;
                    if (empty($row[0])) continue;
                    $entity = $this->Products->newEmptyEntity();
                    $data = [
                        'category_id' => 1,
                        'name' => $row[0],
                        'import_date' => FrozenTime::now(),
                        'original_id' => 1,
                        'barcode' => $row[14],
                        'imported_quantity' => 0,
                        'quantity' => 0,
                        'unit_price' => $this->convertStringToNumber($row[32]),
                        'sell_price' => $this->convertStringToNumber($row[31]),
                        'sell_price_2' => $this->convertStringToNumber($row[33]),
                        'wet' => $this->convertStringToNumber($row[15]),
                        'unit' => $row[16],
                        'description' => empty($row[3]) ? " " : $row[3],
                    ];
                    $entities[] = $this->Products->patchEntity($entity, $data);
                    if(count($entities) == 100) {
                        if(!$this->Products->saveMany($entities)) {
                            foreach ($entities as $entity) {
                                if(count($entity->getErrors()) > 0) {
                                    $errors[] = $entity->getErrors();
                                }
                            }
                        } else {
                            $entities = [];
                        }
                    }
                    if(count($errors) > 0) {
                        break;
                    }
                }
                
                // $file = new File($importFile['tmp_name']);
                // $content = $file->read();
            }
            $this->viewBuilder()->setClassName('Json');
            $this->set(compact(['errors','redirect']));
            $this->viewBuilder()->setOption('serialize', ['errors', 'redirect']);
        }
    }

    /**
     * Inventory method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function inventory() {
        // 提供者一覧
        $sponsors = $this->Masters
            ->find('byType', ['type' => MastersTable::SPONSOR])
            ->all()
            ->combine('id','name')
            ->toArray();
        $sponsors = array_merge(['Chọn nhà phân phối'], $sponsors);
        $this->paginate += [
            'contain' => ['Categories'],
        ];
        // 検索条件
        $searchParam = $this->request->getData();
        // 入庫数
        $inventories = $this->_getStockProductQuantity($searchParam);
        $products = $this->Products->find('search', ['search' => $searchParam])->find('valid')
            ->contain([
                'ProductInventories' => function($query) {
                    return $query->limit(1);
                }
            ]);
        $products = $this->paginate($products);

        $categoryList = $this->Products->Categories->find()
            ->all()
            ->combine('id', 'name')
            ->toArray();
        $categoryList = ['All'] + $categoryList;

        $this->set(compact('products', 'categoryList', 'searchParam', 'inventories', 'sponsors'));
    }

    /**
     * 商品毎に入庫・出庫品数を取得
     */
    private function _getStockProductQuantity($products = []) {
        $inventories = [];
        foreach ($products as $key => $product) {
            $order = $this->Products->OrderDetails->Orders->find('stockout', ['product_id' => $product->id])->first();
            $inventories[$product->id] = empty($order) ? 0 : 0;
        }
        // // 出庫品数を取得
        // $solds = $this->Products->OrderDetails->Orders->find('stockout')
        //     ->all()
        //     ->combine(function(Order $order) {
        //         return $order->_matchingData['OrderDetails']->product_id;
        //     }, function(Order $order) {
        //         return $order;
        //     })
        //     ->toArray();

        // // 入庫品数を取得
        // $inventories = $this->Products
        //     ->find('search', ['search' => $searchParam])
        // // $inventories = $this->Products->ProductInventories->find('search', ['search' => $searchParam])
        // //     ->find('stockin')
        //     ->all()
        //     ->map(function(Product $product) use($solds) {
        //         if(isset($solds[$product->product_id])) {
        //             $product['sold'] = $solds[$product->product_id]->sum;
        //         }
        //         return $product;
        //     })
        //     ->combine('product_id', function(Product $product) {
        //         return $product;
        //     })
        //     ->toArray();
        return $inventories;
    }

    private function sendNotify() {
        $FIREBASE_API_KEY = "AAAAFkT__IQ:APA91bGmZt6pTEszdNQfAtAUySHXQHPi15ppxogks1QpCoPt8efpngzUoCnPKw-TZv0DMDnmDMCTEpo01KcH9KUXj0nun_6k-6VIMZ-30SPqeOwqUt-xF-2FFHPWswhb8Bu568tUsVj7";
        $device_token = 'fARpDTXbSEpCnlFX9mcklR:APA91bEek68XOlXNL5zbdw649po1XBy_I9p9hbtM3FmmoaU7wKTD6xF1WgoiIsnyDksDRo7MjndeXxbrh4lTrfaDZazx_crjFnlBh-GTWmOt9PmpzEcKrHro3O5mz_V8MMYlIoukuSim';
        $end_point = "https://fcm.googleapis.com/fcm/send";
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );

        $data = array(
            "to" => $device_token
        ,	"notification" => array(
                "body" => 'Immediate Order'
            ,	"title" => 'Order'
            ,	"badge" => 1
            ,	"sound" => "default",
            )
        ,	"data" => array(
                "body" => "AAAA"
            ,	"title" => "TEST"
            )
        ,	"apns" => [
                "payload" => [
                    "aps" => [
                        "sound" => "default",
                        "badge" => 1
                    ],
                ],
            ],
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $end_point);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $push_result = curl_exec($ch);
        var_dump($push_result);
        curl_close($ch);
    }
}
