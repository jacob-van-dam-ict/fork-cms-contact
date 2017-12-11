<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Common\Doctrine\Type\AbstractImageType;
use Common\Doctrine\ValueObject\AbstractImage;

final class ImageDBALType extends AbstractImageType
{
    /**
     * {@inheritdoc}
     */
	protected function createFromString(string $imageFileName): AbstractImage
	{
		return Image::fromString($imageFileName);
	}

    /**
     * {@inheritdoc}
     */
	public function getName()
	{
		return 'slider_slide_image_type';
	}
}
