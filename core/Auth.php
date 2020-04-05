<?php

namespace Core;

use App\Models\User;
use Doctrine\ORM\ORMException;

class Auth
{
    const HASH_KEY = 'auth_hash';
    const COOKIE_EXPIRE = 3600;

    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public static function login(string $login, string $password) :bool
    {
        $em = EntityManager::get();
        $repository = $em->getRepository(User::class);
        /** @var User $user */
        $user = $repository->findOneBy(['email' => $login]);
        if (null == $user) {
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        $authHash = md5($user->getId().time());
        $user->setAuthHash($authHash);
        self::saveUser($user);

        setcookie(self::HASH_KEY, $authHash, time()+self::COOKIE_EXPIRE, "/");

        return true;
    }

    /**
     * @return bool
     */
    public static function logout() :bool
    {
        /** @var User $user */
        $user = self::getAuthUser();
        if (null == $user) {
            return false;
        }

        $user->setAuthHash('');
        self::saveUser($user);

        unset($_COOKIE[self::HASH_KEY]);
        setcookie(self::HASH_KEY, null, time()-self::COOKIE_EXPIRE, "/");

        return true;
    }

    /**
     * @return bool
     */
    public static function isAuth() :bool
    {
        /** @var User $user */
        $user = self::getAuthUser();
        if (null == $user) {
            return false;
        }

        if (!$user->getAuthHash()) {
            return false;
        }

        setcookie(self::HASH_KEY, $user->getAuthHash(), time()+self::COOKIE_EXPIRE, "/");

        return true;
    }

    /**
     * @return object|null
     */
    public static function getAuthUser()
    {
        if (!isset($_COOKIE[self::HASH_KEY])) {
            return null;
        }

        $em = EntityManager::get();
        $repository = $em->getRepository(User::class);

        return $repository->findOneBy(['auth_hash' => $_COOKIE[self::HASH_KEY]]);
    }

    /**
     * @param User $user
     * @return bool
     */
    private static function saveUser(User $user) :bool
    {
        $em = EntityManager::get();
        try {
            $em->persist($user);
            $em->flush();
        } catch (ORMException $ORMException) {
            return false;
        }

        return true;
    }
}
