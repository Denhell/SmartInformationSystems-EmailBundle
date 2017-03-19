<?php
namespace SmartInformationSystems\EmailBundle\Service\Mailer;

class ConfigurationContainer
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @param array $config
     *
     * @return ConfigurationContainer
     */
    public function setConfig(array $config): ConfigurationContainer
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->config['from_name'];
    }

    /**
     * @return string
     */
    public function getFromEmail()
    {
        return $this->config['from_email'];
    }

    /**
     * @return string
     */
    public function getReplyTo()
    {
        return $this->config['reply_to'] ?? null;
    }

    /**
     * @return boolean
     */
    public function isImagesAsAttachments()
    {
        return $this->config['images_as_attachments'] ?? false;
    }

    /**
     * @return array
     */
    public function getTestDomains(): array
    {
        return $this->config['test_domains'] ?? [];
    }
}
