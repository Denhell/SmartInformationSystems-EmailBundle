<?php
namespace SmartInformationSystems\EmailBundle\Spool;

use Doctrine\ORM\EntityManager;
use SmartInformationSystems\EmailBundle\Entity\Email;
use SmartInformationSystems\EmailBundle\Service\Mailer\ConfigurationContainer;

class EntitySpool extends \Swift_ConfigurableSpool
{
    /**
     * @var ConfigurationContainer
     */
    private $configuration;

    /**
     * Подключение к БД.
     *
     * @var EntityManager
     */
    private $em;

    public function __construct(ConfigurationContainer $configurationContainer, EntityManager $em)
    {
        $this->configuration = $configurationContainer;
        $this->em = $em;

        // Лимит по умолчанию
        $this->setMessageLimit(100);
    }

    /**
     * @inheritdoc
     */
    public function start()
    {
    }

    /**
     * @inheritdoc
     */
    public function stop()
    {
    }

    /**
     * @inheritdoc
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function queueMessage(\Swift_Mime_Message $message)
    {
        $email = new Email();
        $email->setSubject($message->getSubject());

        $email->setEmail(key($message->getTo()));

        $fromArray = $message->getFrom();
        $email
            ->setFromEmail(key($fromArray))
            ->setFromName(current($fromArray))
        ;

        $email->setBody($message->getBody());

        $this->em->persist($email);
        $this->em->flush($email);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function flushQueue(\Swift_Transport $transport, &$failedRecipients = null)
    {
        if (!$transport->isStarted()) {
            $transport->start();
        }

        $failedRecipients = (array)$failedRecipients;

        $amount = 0;

        /** @var Email[] $emails */
        $emails = $this->em->getRepository(Email::class)->findBy(
            array('sent' => false),
            array('createdAt' => 'DESC'),
            $this->getMessageLimit()
        );

        foreach ($emails as $email) {
            $this->em->beginTransaction();
            /** @var Email $email */
            $email = $this->em->find(Email::class, $email->getId(), \Doctrine\DBAL\LockMode::PESSIMISTIC_WRITE);
            if ($email->isSent()) {
                $this->em->rollback();
                continue;
            }

            $message = \Swift_Message::newInstance()
                ->setSubject($email->getSubject())
                ->setFrom($email->getFromEmail(), $email->getFromName())
                ->setTo($email->getEmail())
            ;

            if ($replyTo = $this->configuration->getReplyTo()) {
                $message->setReplyTo($replyTo);
            }

            $message->setBody(
                $this->configuration->isImagesAsAttachments()
                    ? $this->attacheImages($email->getBody(), $message)
                    : $email->getBody(),
                'text/html',
                'utf-8'
            );

            if ($this->isTestMessage($message) || $transport->send($message, $failedRecipients)) {

                $email->setSent(true);
                $email->setSentAt(new \DateTime());

                $this->em->persist($email);
                $this->em->flush($email);

                $amount++;
            } else {
                $this->em->rollback();
                throw new \RuntimeException('Error sending email: ' . $email->getId());
            }

            $this->em->commit();
        }

        return $amount;
    }

    /**
     * @param string $body
     * @param \Swift_Message $message
     *
     * @return string
     */
    private function attacheImages($body, \Swift_Message $message)
    {
        if (preg_match_all('/<img.+?src\s*=\s*[\'"]([^\'"]+)[\'"]/i', $body, $matches)) {
            foreach ($matches[1] as $key => $url) {
                if (strpos($body, $matches[0][$key]) === false) {
                    continue;
                }
                if ($img = file_get_contents($url)) {
                    $urlInfo = parse_url($url);
                    $body = str_replace(
                        $matches[0][$key],
                        str_replace(
                            $url,
                            $message->embed(
                                \Swift_Image::newInstance($img, basename($urlInfo['path']))
                            ),
                            $matches[0][$key]
                        ),
                        $body
                    );
                }
            }
        }

        return $body;
    }


    /**
     * @param \Swift_Mime_SimpleMessage $message
     *
     * @return bool
     */
    public function isTestMessage(\Swift_Mime_SimpleMessage $message)
    {
        $email = key($message->getTo());
        foreach ($this->configuration->getTestDomains() as $domain) {
            if (preg_match('/' . $domain . '$/', $email)) {
                return true;
            }
        }

        return false;
    }
}
