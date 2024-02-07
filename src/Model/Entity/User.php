<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $email
 * @property bool $role
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $address
 * @property string|null $tel
 * @property int $point
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $updated
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'email' => true,
        'role' => true,
        'first_name' => true,
        'last_name' => true,
        'address' => true,
        'tel' => true,
        'point' => true,
        'full_name' => true,
        'created' => true,
        'updated' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        // 'password',
    ];

    // Automatically hash passwords when they are changed.
    protected function _setPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password, PASSWORD_DEFAULT);
    }

    protected function _getFullName()
    {
        return $this->first_name . '  ' . $this->last_name;
    }
}
