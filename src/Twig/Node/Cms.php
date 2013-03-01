<?php

class Twig_Node_Cms extends Twig_Node implements Twig_NodeOutputInterface
{
	public function __construct(Twig_Node_Expression $method, Twig_Node_Expression $expr, Twig_Node_Expression $variables = null, $lineno, $tag = null)
    {
        parent::__construct(array('method' => $method, 'expr' => $expr, 'variables' => $variables), array(), $lineno, $tag);
    }

	public function compile(Twig_Compiler $compiler)
	{
		$method = $this->getNode('method')->getAttribute('name');

		if (in_array($method, array('region', 'global', 'snippet', 'component'))) {
			$this->_compileRegion($compiler, $method);
		}
	}

	private function _compileRegion(Twig_Compiler $compiler, $region)
	{
		// TODO: Only show data-editable if logged in...
		$regionMethod = 'get'.ucfirst($region);
		$compiler->write("\$page = \$context['page'];\n");

		if ($this->getNode('expr') !== null) {
			$compiler->write("\$vars = ")
				->subcompile($this->getNode('variables'))
				->write(";\n");
		}

		$compiler->write("\$region = \$page->$regionMethod(")
			->subcompile($this->getNode('expr'))
			->write(");\n")
			->write("echo '<div id=")
			->subcompile($this->getNode('expr'))
			->write(" data-editable=\"$region\">';\n")
			->write("if (\$region !== null) {\n")
			->indent()
			->write("echo \$region->getData();\n")
			->outdent()
			->write("} else {\n")
			->indent()
			->write("echo isset(\$vars['default']) ? \$vars['default'] : \"No content found.\";\n")
			->outdent()
			->write("}\n")
			->write("echo '</div>';\n")
			->write("unset(\$vars, \$region);\n");
	}

}