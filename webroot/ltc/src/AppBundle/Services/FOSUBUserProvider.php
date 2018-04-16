<?php

namespace AppBundle\Services;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Exception\AccountNotLinkedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class FOSUBUserProvider extends \HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider
{
    protected $userManager;

    /**
     * @param UserResponseInterface $response
     * @return \FOS\UserBundle\Model\UserInterface|UserInterface
     * @throws \Exception
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $username = $response->getUsername();
        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        if (null === $user || null === $username) {
            throw new AccountNotLinkedException(sprintf("User '%s' not found.", $username));
        }
        $log = new Logger('AUTHENTICATION');
        $log->pushHandler(new StreamHandler(__DIR__ . '/../../../app/logs/authentications.log', Logger::DEBUG));
        $log->info(sprintf('%s %s (%s) %s %s', 'User: ', $user->getUsername(), $username, ' was authenticated with ID: ', $user->getId()));
        return $user;
    }

}
