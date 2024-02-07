<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \App\Model\Table\CategoriesTable&\Cake\ORM\Association\BelongsTo $Categories
 * @property \App\Model\Table\ImageProductsTable&\Cake\ORM\Association\HasMany $ImageProducts
 *
 * @method \App\Model\Entity\Product newEmptyEntity()
 * @method \App\Model\Entity\Product newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Product get($primaryKey, $options = [])
 * @method \App\Model\Entity\Product findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Product[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Product|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
{
    public static $sponsors = [
        'VN',
        'JP',
        'UR'
    ];
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior("Search.Search");

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ImageProducts', [
            'foreignKey' => 'product_id',
        ]);
        $this->hasMany('ShoppingCarts', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('ProductInventories', [
            'foreignKey' => 'product_id'
        ]);
        $this->hasMany('OrderDetails', [
            'foreignKey' => 'product_id'
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
            ->integer('category_id')
            ->notEmptyString('category_id', REQUIRED_INPUT);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', REQUIRED_INPUT);

        $validator
            ->notEmptyString('made_in', 'Please input value')
            ->add('made_in', 'validValue', ['rule' => ['range', 0, 3], 'message' => '[0~3]まで登録してください']);

        $validator
            ->maxLength('sponsor_name', 5, __(OVER_MAX_LENGTH, 255))
            ->isEmptyAllowed('sponsor_name', true);

        $validator
            ->maxLength('sponsor_tel', 255, 'Please input under 255 charactors')
            ->isEmptyAllowed('sponsor_name', true);

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
        $rules->add($rules->existsIn('category_id', 'Categories'), ['errorField' => 'category_id']);

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
                        $query = $query->where(['id' => $filter->value()]);
                    }
                }
            ])
            ->callback('category_id', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['category_id' => $filter->value()]);
                    }
                }
            ])
            ->callback('product_name', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['Products.name LIKE' => '%' . $filter->value() . '%']);
                    }
                }
            ])
            ->callback('sponsor_name', [
                'callback' => function($query, $args, $filter) {
                    if($filter->value()) {
                        $query = $query->where(['sponsor_name LIKE' => '%' . $filter->value() . '%']);
                    }
                }
            ]);
        return $searchManager;
    }

    public function findProductCart(Query $query, $product_ids) {
        return $query->contain([
            'Categories',
            'ImageProducts' => function(Query $query) {
                return $query->limit(1);
            },
            'ProductInventories' => function($query) {
                return $query
                ->orderDesc('ProductInventories.date');
            }
        ])
        ->where(['Products.id IN' => $product_ids]);
    }

    public function findValid(Query $query) {
        return $query->where(['deleted IS NULL']);
    }
}
