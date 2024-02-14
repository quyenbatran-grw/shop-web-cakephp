<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \App\Model\Table\OrderDetailsTable&\Cake\ORM\Association\HasMany $OrderDetails
 *
 * @method \App\Model\Entity\Order newEmptyEntity()
 * @method \App\Model\Entity\Order newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Order[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
{
    const PREPARING = 0;
    const PAID = 1;
    const DELIVERING = 2;
    const DELIVERED = 3;
    const CANCELED = 4;
    const CASH = 0;
    const BANKING = 1;
    // 注文のステータス
    public static $statusList = [
        self::PREPARING => 'Đang xử lý'
    // ,   self::PAID => 'Đã thanh toán'
    ,   self::DELIVERING => 'Đang giao hàng'
    ,   self::DELIVERED => 'Đã giao'
    ,   self::CANCELED => 'Đã hủy'
    ];
    // 支払状態
    public static $paymentStatus = [
        self::PREPARING => 'Chưa thanh toán'
    ,   self::PAID => 'Thanh toán 1 phần'
    ,   self::DELIVERED => 'Đã thanh toán'
    ,   self::CANCELED => 'Đã hoàn tiền'
    ];
    // 注文のステータス背景色
    public static $statusBackground = [
        self::PREPARING => 'bg-danger'
    ,   self::PAID => 'bg-warning'
    ,   self::DELIVERING => 'bg-info'
    ,   self::DELIVERED => 'bg-success'
    ,   self::CANCELED => 'bg-secondary'
    ];
    // 検索条件の期間
    public static $filterTimes = ['Tháng hiện tại', '3 tháng trước', '6 tháng trước'];
    // 配達方法
    public static $deliveryTypes = ['Nhập tại của hàng', 'Giao tận nhà(MIỄN PHÍ)'];
    // 支払方法
    public static $paymentTypes = [self::CASH => 'Tiền mặt', self::BANKING => 'Chuyển khoản'];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior("Search.Search");

        $this->hasMany('OrderDetails', [
            'foreignKey' => 'order_id',
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('order_number')
            ->maxLength('order_number', 20)
            ->allowEmptyString('order_number')
            ->add('order_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->scalar('order_name')
            ->maxLength('order_name', 255)
            ->requirePresence('order_name', 'create')
            ->notEmptyString('order_name');

        $validator
            ->scalar('order_address')
            ->maxLength('order_address', 255)
            ->requirePresence('order_address', 'create')
            ->notEmptyString('order_address');

        $validator
            ->scalar('order_tel')
            ->maxLength('order_tel', 15)
            ->requirePresence('order_tel', 'create')
            ->notEmptyString('order_tel');

        $validator
            ->decimal('order_amount')
            ->requirePresence('order_amount', 'create')
            ->notEmptyString('order_amount');

        $validator
            ->decimal('payment_type')
            ->requirePresence('payment_type', 'create')
            ->notEmptyString('payment_type');

        $validator
            ->scalar('memo')
            ->allowEmptyString('memo');

        $validator
            ->scalar('delivery_type')
            ->notEmptyString('delivery_type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['order_number'], ['allowMultipleNulls' => true]), ['errorField' => 'order_number']);

        return $rules;
    }

    /**
     * 検索条件で絞り込む
     *
     */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->callback('order_number', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['order_number' => $filter->value()]);
                    }
                }
            ])
            ->callback('status', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value() && $filter->value() != 0) {
                        $query = $query->where(['status' => $filter->value() - 1]);
                    }
                }
            ])
            ->callback('immediate', [
                'callback' => function($query, $args, $filter) {
                    $immediate = $filter->value();
                    if($immediate != 2) {
                        $query = $query->where(['immediate' => $filter->value()]);
                    }
                }
            ])
            ->callback('start_date', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['created >=' => $filter->value()]);
                    }
                }
            ])
            ->callback('end_date', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $end_date = $filter->value() . ' 23:59:59';
                        $query = $query->where(['created <=' => $end_date]);
                    }
                }
            ]);
        return $searchManager;
    }

    /**
     * 出庫品数取得
     *
     * @param \Cake\ORM\Query $query
     * @return \Cake\ORM\Query
     */
    public function findStockOut(Query $query) {
        return $query
            ->where(['Orders.status <>' => OrdersTable::CANCELED])
            ->innerJoinWith('OrderDetails', function ($q) {
                return $q;
            })
            ->select([
                'OrderDetails.product_id',
                'sum' => $query->func()->sum('quantity'),
            ])
            ->group(['OrderDetails.product_id']);
    }
}
