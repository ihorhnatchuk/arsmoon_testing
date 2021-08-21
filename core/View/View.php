<?php

namespace Core\View;

use Core\Contracts\View\View as ViewContract;

class View implements ViewContract
{
	public function render(string $name, array $data = [])
	{
		extract($data);
		
		include(VIEW_PATH. $name.'.php');
	}
}