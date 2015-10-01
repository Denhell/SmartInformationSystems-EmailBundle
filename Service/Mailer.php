<?php

namespace SmartInformationSystems\EmailBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Класс для отправки писем.
 *
 */
class Mailer
{
    private $mailer;
    private $templating;

    private $fromEmail;
    private $fromName;

    public function __construct(ContainerInterface $container, \Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;

        $this->fromEmail = $container->getParameter('smart_information_systems_email.from_email');
        $this->fromName = $container->getParameter('smart_information_systems_email.from_name');
    }

    /**
     * Отправка письма.
     *
     * @param string $email Кому
     * @param string $template Шаблон
     * @param array $templateVars Переменные шаблона
     * @param array $from От кого, массив (address, name)
     *
     * @return int
     */
    public function send($email, $template, array $templateVars = array(), array $from = array())
    {
        $message = \Swift_Message::newInstance()
            ->setSubject(
                $this->templating->render(
                    $template . '/subject.text.twig',
                    $templateVars
                )
            )
            ->setTo($email);

        if (empty($from)) {
            $message->setFrom($this->fromEmail, $this->fromName);
        } else {
            $message->setFrom($from[0], $from[1]);
        }

        $templateVars = array_merge(
            $templateVars,
            array(
                '_subject' => $message->getSubject(),
            )
        );

        $message->setBody(
            $this->templating->render(
                $template . '/body.html.twig',
                $templateVars
            ),
            'text/html',
            'utf8'
        );

        return $this->mailer->send($message);
    }
}
