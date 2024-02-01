<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

use function PHPSTORM_META\type;

/**
 * Masters Model
 *
 * @method \App\Model\Entity\Master newEmptyEntity()
 * @method \App\Model\Entity\Master newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Master[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Master get($primaryKey, $options = [])
 * @method \App\Model\Entity\Master findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Master patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Master[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Master|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Master saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Master[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MastersTable extends Table
{
    const MST_TYPE_0 = 0;
    const MST_TYPE_1 = 1;
    const MST_TYPE_2 = 2;
    public static $master_type = [
        self::MST_TYPE_0 => 'Type 1',
        self::MST_TYPE_1 => 'Type 2',
        self::MST_TYPE_2 => 'Type 3',
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

        $this->setTable('masters');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('type')
            ->requirePresence('type', 'create')
            ->notEmptyString('type', REQUIRED_INPUT);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', REQUIRED_INPUT);

        $validator
            ->integer('rank')
            ->notEmptyString('rank');

        return $validator;
    }

    public function findByType(Query $query, $options = [])
    {
        if(isset($options['type'])) {
            $query->where(['type' => $options['type']]);
        }
        return $query;
    }
}
