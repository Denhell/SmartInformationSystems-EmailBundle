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
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('sis_email:test')
            ->setDescription('Sending test email')
            ->addOption('email', null, InputOption::VALUE_REQUIRED, 'E-mail')
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getOption('email');

        $output->writeln(
            sprintf('Sending test email to: %s', $email)
        );

        $message = \Swift_Message::newInstance()
            ->setSubject('SmartInformationSystemsEmailBundle test email')
            ->setFrom('info@smart-systems.ru', 'Smart Information Systems')
            ->setTo($email);
        $message->setBody(
            $this->getContainer()->get('templating')->render(
                'SmartInformationSystemsEmailBundle:Email:test.html.twig',
                ['email' => $email]
            ),
            'text/html',
            'utf8'
        );

        $this->getContainer()->get('mailer')->send($message);

        $output->writeln('Sent!');
    }
}
