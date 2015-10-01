<?php

namespace SmartInformationSystems\EmailBundle\Service;

use Symfony\Component\Templating\EngineInterface;

/**
 * Класс для отправки писем.
 *
 */
class Mailer
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
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
    public function send($email, $template, array $templateVars = array(), array $from)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject(
                $this->templating->render(
                    $template . '/subject.text.twig',
                    $templateVars
                )
            )
            ->setFrom($from[0], $from[1])
            ->setTo($email);

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
