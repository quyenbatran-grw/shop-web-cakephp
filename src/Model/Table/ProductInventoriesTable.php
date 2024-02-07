<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductInventories Model
 *
 * @property \App\Model\Table\ProductsTable&\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ProductInventory newEmptyEntity()
 * @method \App\Model\Entity\ProductInventory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ProductInventory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductInventory get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductInventory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ProductInventory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductInventory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductInventory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductInventory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductInventory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductInventory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductInventory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ProductInventory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductInventoriesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('product_inventories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior("Search.Search");

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
            'joinType' => 'INNER',
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
            ->notEmptyString('product_id');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmptyDateTime('date');

        $validator
            ->decimal('unit_price')
            ->requirePresence('unit_price', 'create')
            ->notEmptyString('unit_price');

        $validator
            ->notEmptyString('quantity');

        $validator
            ->notEmptyString('unit', REQUIRED_INPUT);

        $validator
            ->scalar('memo')
            ->allowEmptyString('memo');

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
        $rules->add($rules->existsIn('product_id', 'Products'), ['errorField' => 'product_id']);

        return $rules;
    }



    /**
     * 検索条件で絞り込む
     */
    public function searchManager()
    {
        $searchManager = $this->behaviors()->Search->searchManager();
        $searchManager
            ->callback('product_id', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['product_id' => $filter->value()]);
                    }
                }
            ])
            ->callback('product_name', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['Products.name LIKE ' => '%'.$filter->value().'%']);
                    }
                }
            ])
            ->callback('start_date', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['date >=' => $filter->value()]);
                    }
                }
            ])
            ->callback('end_date', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $end_date = $filter->value() . ' 23:59:59';
                        $query = $query->where(['date <=' => $end_date]);
                    }
                }
            ])
            ->callback('unit', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value() > 0) {
                        if($filter->value() == 99) {
                            $query = $query->where([
                                'OR' => [
                                    'unit' => $filter->value(),
                                    'unit' => 0
                                ]
                            ]);
                        } else {
                            $query = $query->where(['unit' => $filter->value()]);
                        }
                    }
                }
            ]);
        return $searchManager;
    }
}
