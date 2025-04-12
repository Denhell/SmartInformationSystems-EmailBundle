<?php
namespace SmartInformationSystems\EmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Письмо в очереди на отправку
 */
#[ORM\Table(name: 'sis_email')]
#[ORM\Index(name: 'i_sent', columns: ['sent'])]
#[ORM\Index(name: 'i_email', columns: ['email'])]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class Email
{
    /**
     * Идентификатор
     *
     * @var integer
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer', options: ['unsigned' => true])]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    protected ?int $id = null;

    /**
     * Адрес получателя
     *
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $email;

    /**
     * Тема
     *
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $subject;

    /**
     * Тело письма
     *
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: false)]
    protected string $body;

    /**
     * Адрес отправителя
     *
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $fromEmail;

    /**
     * Имя отправителя
     *
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: false)]
    protected string $fromName;

    /**
     * Отправлено ли
     *
     * @var bool
     */
    #[ORM\Column(type: 'boolean')]
    protected ?bool $sent = null;

    /**
     * Дата создания
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: 'datetime', nullable: false)]
    protected \DateTimeInterface $createdAt;

    /**
     * Дата последнего изменения
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $updatedAt = null;

    /**
     * Дата отправки
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $sentAt = null;

    public function __construct()
    {
        $this->sent = false;
    }


    /**
     * Возвращает идентификатор
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $email
     *
     * @return Email
     */
    public function setEmail($email): Email
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $subject
     *
     * @return Email
     */
    public function setSubject($subject): Email
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $body
     *
     * @return Email
     */
    public function setBody($body): Email
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $fromEmail
     *
     * @return Email
     */
    public function setFromEmail($fromEmail): Email
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param string $fromName
     *
     * @return Email
     */
    public function setFromName($fromName): Email
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param boolean $sent
     *
     * @return Email
     */
    public function setSent($sent): Email
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Возвращает отправлено ли письмо.
     *
     * @return boolean
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $sentAt
     *
     * @return Email
     */
    public function setSentAt($sentAt): Email
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSentAt()
    {
        return $this->sentAt;
    }

    #[ORM\PrePersist]
    public function prePersistHandler()
    {
        $this->createdAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function preUpdateHandler()
    {
        $this->updatedAt = new \DateTime();
    }
}
