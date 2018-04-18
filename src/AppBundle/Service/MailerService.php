<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 09.04.2018
 * Time: 17:35
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use EmailLabs\Actions\Sendmail;

class MailerService
{

    private $mailer;

    public function __construct(string $mailAppKey, string $mailAppSecret)
    {
        $this->mailer = new Sendmail();
        $this->mailer->setAppKey($mailAppKey);
        $this->mailer->setAppSecret($mailAppSecret);
    }

    public function sendInvitationMail(User $user)
    {
        $adresses = array(
            $user->getEmail() => array(
                'message_id' => $user->getActivationToken()
            )
        );

        $this->mailer->setData('from', 'houselock.app@gmail.com');
        $this->mailer->setData('from_name', 'Houselock');
        $this->mailer->setData('to', $adresses);
        $this->mailer->setData('subject', 'Właściciel zaprosił Cię do aplikacji Houselock');
        $this->mailer->setData('smtp_account', '1.houselock.smtp');
        $this->mailer->setData('html', '<h1>HouseLock</h1>
            <p>Właściciel zaprosił Cię do aplikacji. Aby potwierdzić, kliknij w link poniżej:</p>
            <p>
            <a href="http://houselock.local/accept/invitation/' + $user->getActivationToken() + '">
            http://houselock.local/accept/invitation/' + $user->getActivationToken() + '</a>
            </p>');

        $this->mailer->getResult();
    }
}