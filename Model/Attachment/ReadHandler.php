<?php

declare(strict_types = 1);

/**
 * File: ReadHandler.php
 *
 * @author Bartosz Kubicki bartosz.kubicki@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace LizardMedia\ProductAttachment\Model\Attachment;

use \LizardMedia\ProductAttachment\Api\AttachmentRepositoryInterface;
use \Magento\Framework\EntityManager\Operation\ExtensionInterface;

/**
 * Class ReadHandler
 * @package LizardMedia\ProductAttachment\Model\Attachment
 */
class ReadHandler implements ExtensionInterface
{
    /**
     * @var \LizardMedia\ProductAttachment\Api\AttachmentRepositoryInterface
     */
    private $attachmentRepository;


    /**
     * @param \LizardMedia\ProductAttachment\Api\AttachmentRepositoryInterface $attachmentRepository
     */
    public function __construct(AttachmentRepositoryInterface $attachmentRepository)
    {
        $this->attachmentRepository = $attachmentRepository;
    }


    /**
     * @param object $entity
     * @param array $arguments
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface|object $entity
     */
    public function execute($entity, $arguments = [])
    {
        $entityExtension = $entity->getExtensionAttributes();
        $attachments = $this->attachmentRepository->getAttachmentsByProduct($entity);

        if ($attachments) {
            $entityExtension->setProductAttachments($attachments);
        }

        $entity->setExtensionAttributes($entityExtension);
        return $entity;
    }
}
