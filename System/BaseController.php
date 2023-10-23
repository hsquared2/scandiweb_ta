<?php

namespace System;

abstract class BaseController {
	protected string $title = '';
	protected string $content = '';
	
	
	public function render() : string{
		return Template::render(__DIR__ . '/../v_main.php', [
			'title' => $this->title,
			'content' => $this->content,
		]);
	}

}