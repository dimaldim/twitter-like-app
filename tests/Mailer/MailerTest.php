<?php

namespace App\Tests\Mailer;

use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('test@test.com');

        $swiftMailer = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $swiftMailer->expects($this->once())
            ->method('send')
            ->with(
                $this->callback(
                    function ($subject) {
                        $messageStr = (string)$subject;
                        return strpos($messageStr, "From: mitko@mitko.com") !== false
                            && strpos($messageStr, "This is a message body") !== false;
                    }
                )
            );

        $twigMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigMock->expects($this->once())
            ->method('render')
            ->with(
                'email/registration.html.twig',
                [
                    'user' => $user,
                ]
            )
            ->willReturn('This is AA message body');

        $mailer = new Mailer($swiftMailer, $twigMock, 'mitko@mitko.com');
        $mailer->sendConfirmationEmail($user);
    }
}
