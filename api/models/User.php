<?php
/**
 * Created at: 2017-03-15 21:16
 */
namespace api\models;

/**
 * Signup form
 */
class User extends \common\models\User
{

    public $username;

    public $email;

    public $password;

    /**
     * Signs user up.
     *
     * @return \common\models\User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (! $this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
