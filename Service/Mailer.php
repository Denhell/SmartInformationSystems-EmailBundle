<?php
namespace SmartInformationSystems\EmailBundle\Service;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Twig\Environment;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;

class Mailer
{

    public function __construct(
        private Mailer\ConfigurationContainer $configurationContainer,
        private SymfonyMailer $mailer,
        private Environment $templating,
    ) {

    }

    /**
     * Отправка письма
     *
     * @param string $email Кому
     * @param string $template Шаблон
     * @param array $templateVars Переменные шаблона
     * @param array $from От кого, массив (address, name)
     *
     * @return int
     */
    public function send($email, $template, array $templateVars = [], array $from = [])
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
            $message->setFrom($this->configuration->getFromEmail(), $this->configuration->getFromName());
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
