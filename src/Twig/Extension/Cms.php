<?php

class Twig_Extension_Cms extends Twig_Extension
{
	public function getTokenParsers()
	{
		return array(
			new Twig_TokenParser_Cms(),
		);
	}

	public function getFilters()
	{
		return array();
	}

	public function getFunctions()
	{
		return array(
			new Twig_SimpleFunction('cms_context_dump', 'cms_context_dump', array('is_safe' => array('html'), 'needs_environment' => true, 'needs_context' => true)),
		);
	}

	public function getTests()
	{
		return array();
	}

	public function getName()
	{
		return 'cms';
	}
}

function cms_context_dump(Twig_Environment $env, $context)
{
	ob_start() and var_dump($context);

	return ob_get_clean();
}