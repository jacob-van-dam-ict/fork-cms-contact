<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Core\Engine\Model;
use Common\Doctrine\ValueObject\AbstractImage;

final class Image extends AbstractImage
{
    /**
     * {@inheritdoc}
     */
    protected function getUploadDir(): string
    {
        return 'ContactForm';
    }

    /**
     * {@inheritdoc}
     */
    public function prepareToUpload(): void
    {
        if ($this->getFile() !== null) {
            $this->namePrefix = str_replace(
                '.' . $this->getFile()->getClientOriginalExtension(),
                '',
                $this->getFile()->getClientOriginalName()
            );
        }

        parent::prepareToUpload();
    }

    /**
     * {@inheritdoc}
     */
    public function getWebPath(string $subDirectory = null): string
    {
        // Generate thumbnails when required
        if (!file_exists($this->getAbsolutePath($subDirectory) ) && preg_match('/^([0-9]+)x([0-9]+)$/', $subDirectory)) {
            if (!is_dir($this->getUploadRootDir($subDirectory))) {
                mkdir($this->getUploadRootDir($subDirectory));
            }

            Model::generateThumbnails(
                FRONTEND_FILES_PATH . '/' . $this->getTrimmedUploadDir(),
                $this->getAbsolutePath('source')
            );
        }

        return parent::getWebPath($subDirectory);
    }
}
