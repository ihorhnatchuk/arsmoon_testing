<?php

namespace Core\Contracts\View;

interface View
{
	/**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render(string $name);
}