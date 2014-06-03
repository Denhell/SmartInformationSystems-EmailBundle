<?php

namespace SmartInformationSystems\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Письмо в очереди на отправку.
 *
 * @ORM\Entity
 * @ORM\Table(name="sis_email", indexes={@ORM\Index(name="i_sent", columns={"is_sent"}), @ORM\Index(name="i_email", columns={"email"})})
 * @ORM\HasLifecycleCallbacks()
 */
class Email
{
    /**
     * Идентификатор.
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Адрес получателя.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * Тема.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $subject;

    /**
     * Тело письма.
     *
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $body;

    /**
     * Адрес отправителя.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="from_email")
     */
    protected $fromEmail;

    /**
     * Имя отправителя.
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, name="from_name")
     */
    protected $fromName;

    /**
     * Отправлено ли.
     *
     * @var bool
     *
     * @ORM\Column(type="boolean", name="is_sent")
     */
    protected $isSent;

    /**
     * Дата создания.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * Дата последнего изменения.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Дата отправки.
     *
     * @var \DateTime
     *
     * @ORM\Column(name="sent_at", type="datetime", nullable=true)
     */
    protected $sentAt;

    /**
     * Конструктор.
     *
     */
    public function __construct()
    {
        $this->isSent = FALSE;
    }


    /**
     * Возвращает идентификатор.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Устанавливает адрес получателя.
     *
     * @param string $email Адрес получателя
     *
     * @return Email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Возвращает адрес получателя.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Устанавливает тему.
     *
     * @param string $subject Тема
     *
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Возвращает тему.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Устанвливает тело.
     *
     * @param string $body Тело
     * @return Email
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Возвращает тело.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Устанавливает адрес отправителя.
     *
     * @param string $fromEmail Адрес отправителя
     *
     * @return Email
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * Возвращает адрес отправителя.
     *
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * Устанавливает имя отправителя.
     *
     * @param string $fromName Имя отправителя
     *
     * @return Email
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Возвращает имя отправителя.
     *
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Устанавливает отправлено ли письмо.
     *
     * @param boolean $isSent Отправлено ли письмо
     *
     * @return Email
     */
    public function setIsSent($isSent)
    {
        $this->isSent = $isSent;

        return $this;
    }

    /**
     * Возвращает отправлено ли письмо.
     *
     * @return boolean
     */
    public function getIsSent()
    {
        return $this->isSent;
    }

    /**
     * Устанавливает дату создания.
     *
     * @param \DateTime $createdAt
     * @return Email
     */
    private function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Возвращает дату создания.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Устанавливает дату последнего обновления.
     *
     * @param \DateTime $updatedAt Дата последнего обновления
     * @return Email
     */
    private function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Возвращает дату последнего обновления.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Устанавливает дату отправки.
     *
     * @param \DateTime $sentAt
     * @return Email
     */
    public function setSentAt($sentAt)
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * Возвращает дату отправки.
     *
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    /**
     * Автоматическая установка даты создания.
     *
     * @ORM\PrePersist
     */
    public function prePersistHandler()
    {
        $this->setCreatedAt(new \DateTime());
    }

    /**
     * Автоматическая установка даты обновления.
     *
     * @ORM\PreUpdate
     */
    public function preUpdateHandler()
    {
        $this->setUpdatedAt(new \DateTime());
    }
}
