<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Modules\User\Service;

use Modules\User\Mappers\AuthToken as AuthTokenMapper;
use Modules\User\Mappers\CookieStolen as CookieStolenMapper;
use Modules\User\Models\AuthToken as AuthTokenModel;

/**
 * Class for "remember me" feature
 */
class Remember
{
    /**
     * Generate and store authtoken and write remember me cookie.
     *
     * @param Modules\User\Service\Login\Result $result
     * @throws \Exception
     */
    public function setRememberMe($result)
    {
        $authTokenModel = new AuthTokenModel();

        // 9 bytes of random data (base64 encoded to 12 characters) for the selector.
        // This provides 72 bits of keyspace and therefore 236 bits of collision resistance (birthday attacks)
        $authTokenModel->setSelector(base64_encode(random_bytes(9)));
        // 33 bytes (264 bits) of randomness for the actual authenticator. This should be unpredictable in all practical scenarios.
        $authenticator = random_bytes(33);
        // SHA256 hash of the authenticator. This mitigates the risk of user impersonation following information leaks.
        $authTokenModel->setToken(hash('sha256', $authenticator));
        $authTokenModel->setUserid($result->getUser()->getId());
        $authTokenModel->setExpires(date('Y-m-d\TH:i:s', strtotime( '+30 days' )));

        if (PHP_VERSION_ID >= 70300) {
            setcookie('remember', $authTokenModel->getSelector().':'.base64_encode($authenticator), [
                'expires' => strtotime('+30 days'),
                'path' => '/',
                'domain' => $_SERVER['SERVER_NAME'],
                'samesite' => 'Lax',
                'secure' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                'httponly' => true,
            ]);
        } else {
            // workaround syntax to set the SameSite attribute in PHP < 7.3
            setcookie('remember', $authTokenModel->getSelector().':'.base64_encode($authenticator), strtotime('+30 days'), '/; samesite=Lax', $_SERVER['SERVER_NAME'], (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'), true);
        }
        $authTokenMapper = new AuthTokenMapper();
        $authTokenMapper->addAuthToken($authTokenModel);
    }

    public function reauthenticate()
    {
        $remember = explode(':', $_COOKIE['remember']);

        if (count($remember) !== 2) {
            $remember[1] = '';
        }
        list($selector, $authenticator) = $remember;

        $authTokenMapper = new AuthTokenMapper();
        $authToken = $authTokenMapper->getAuthToken($selector);

        if ($authToken !== null && strtotime($authToken->getExpires()) >= time()) {
            if (hash_equals($authToken->getToken(), hash('sha256', base64_decode($authenticator)))) {
                $_SESSION['user_id'] = $authToken->getUserid();
                // A new token is generated, a new hash for the token is stored over the old record, and a new login cookie is issued to the user.
                $authTokenModel = new AuthTokenModel();

                $authTokenModel->setSelector($selector);
                // 33 bytes (264 bits) of randomness for the actual authenticator. This should be unpredictable in all practical scenarios.
                $authenticator = random_bytes(33);
                // SHA256 hash of the authenticator. This mitigates the risk of user impersonation following information leaks.
                $authTokenModel->setToken(hash('sha256', $authenticator));
                $authTokenModel->setUserid($_SESSION['user_id']);
                $authTokenModel->setExpires(date('Y-m-d\TH:i:s', strtotime( '+30 days' )));

                if (PHP_VERSION_ID >= 70300) {
                    setcookie('remember', $authTokenModel->getSelector().':'.base64_encode($authenticator), [
                        'expires' => strtotime('+30 days'),
                        'path' => '/',
                        'domain' => $_SERVER['SERVER_NAME'],
                        'samesite' => 'Lax',
                        'secure' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
                        'httponly' => true,
                    ]);
                } else {
                    // workaround syntax to set the SameSite attribute in PHP < 7.3
                    setcookie('remember', $authTokenModel->getSelector().':'.base64_encode($authenticator), strtotime('+30 days'), '/; samesite=Lax', $_SERVER['SERVER_NAME'], (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'), true);
                }
                $authTokenMapper->updateAuthToken($authTokenModel);
            } else {
                // If the series is present but the token does not match, a theft is assumed.
                // The user receives a strongly worded warning and all of the user's remembered sessions are deleted.
                $cookieStolenMapper = new CookieStolenMapper();
                $cookieStolenMapper->addCookieStolen($authToken->getUserid());
                $authTokenMapper->deleteAllAuthTokenOfUser($authToken->getUserid());
            }
        }
    }
}