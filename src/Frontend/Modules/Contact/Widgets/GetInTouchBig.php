<?php

namespace Frontend\Modules\Contact\Widgets;

use Backend\Modules\Contact\Domain\Contact\ContactDataTransferObject;
use Backend\Modules\Slider\Domain\Category\Category;
use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;

/**
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class GetInTouchBig extends FrontendBaseWidget
{
	/**
	 * Execute the extra.
	 */
	public function execute(): void
	{
		parent::execute();

		$this->loadTemplate();

		$data = new ContactDataTransferObject($this->get('fork.settings'));
		$this->template->assign('contactData', $data);

		if ($data->google_maps_key) {
            $this->addJS(
                'https://maps.googleapis.com/maps/api/js?key='.$data->google_maps_key .'&callback=initGetInTouchMaps',
                true,
                false
            );
        }
	}
}
