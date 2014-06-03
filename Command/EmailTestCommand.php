<?php

namespace SmartInformationSystems\EmailBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Отправка тестового письма.
 *
 */
class EmailTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('sis_email:test')
            ->setDescription('Sending test email')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'E-mail')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getOption('email');

        $output->writeLn('Sending test email to: ' . $email);

        $message = \Swift_Message::newInstance()
            ->setSubject('SmartInformationSystemsEmailBundle test email')
            ->setFrom('info@smart-systems.ru', 'Smart Information Systems')
            ->setTo($email);
        $message->setBody(
            $this->getContainer()->get('templating')->render(
                'SmartInformationSystemsEmailBundle:Email:test.html.twig',
                array('email' => $email)
            ),
            'text/html',
            'utf8'
        );

        $this->getContainer()->get('mailer')->send($message);

        $output->writeln('Sent!');
    }
}
