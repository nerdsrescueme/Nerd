<?php

class Twig_TokenParser_Cms extends Twig_TokenParser
{
    public function parse(Twig_Token $token)
    {
        list($method, $variables, $expr) = $this->parseArguments();

        return new Twig_Node_Cms($method, $expr, $variables, $token->getLine(), $this->getTag());
    }

    protected function parseArguments()
    {
        $stream = $this->parser->getStream();
        $method = null;
        $variables = null;

        if ($stream->test(Twig_Token::NAME_TYPE, 'region') or 
            $stream->test(Twig_Token::NAME_TYPE, 'global') or 
            $stream->test(Twig_Token::NAME_TYPE, 'snippet') or 
            $stream->test(Twig_Token::NAME_TYPE, 'component'))
        {
            $method = $this->parser->getExpressionParser()->parseExpression();
        }

        $expr = $this->parser->getExpressionParser()->parseExpression();

        if ($stream->test(Twig_Token::NAME_TYPE, 'with')) {
            $stream->next();
            $variables = $this->parser->getExpressionParser()->parseExpression();
        }

        $stream->expect(Twig_Token::BLOCK_END_TYPE);

        return array($method, $variables, $expr);
    }

    public function getTag()
    {
        return 'cms';
    }
}