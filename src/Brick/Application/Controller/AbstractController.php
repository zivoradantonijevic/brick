<?php

namespace Brick\Application\Controller;

use Brick\View\View;
use Brick\View\ViewRenderer;
use Brick\Http\Response;
use Brick\Di\Annotation\Inject;

/**
 * Base controller class with helper methods for common cases.
 */
abstract class AbstractController
{
    /**
     * @var \Brick\View\ViewRenderer
     */
    private $renderer;

    /**
     * @Inject
     *
     * @param \Brick\View\ViewRenderer $renderer
     */
    public function injectViewRenderer(ViewRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param \Brick\View\View $view
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function renderAsString(View $view)
    {
        if ($this->renderer === null) {
            throw new \RuntimeException('No view renderer has been injected');
        }

        return $this->renderer->render($view);
    }

    /**
     * Renders a View in a Response object.
     *
     * @param \Brick\View\View $view
     *
     * @return \Brick\Http\Response
     */
    protected function render(View $view)
    {
        return $this->html($this->renderAsString($view));
    }

    /**
     * Returns a plain text response.
     *
     * @param string $text
     *
     * @return \Brick\Http\Response
     */
    protected function text($text)
    {
        return $this->createResponse($text, 'text/plain');
    }

    /**
     * Returns an HTML response.
     *
     * @param string $html The HTML content.
     *
     * @return \Brick\Http\Response
     */
    protected function html($html)
    {
        return $this->createResponse($html, 'text/html');
    }

    /**
     * Returns a JSON response.
     *
     * @param mixed   $data   The data to encode, or a valid JSON string if `$encode` == `false`.
     * @param boolean $encode Whether to JSON-encode the data.
     *
     * @return \Brick\Http\Response
     */
    protected function json($data, $encode = true)
    {
        if ($encode) {
            $data = json_encode($data);
        }

        return $this->createResponse($data, 'application/json');
    }

    /**
     * @param string $data
     * @param string $contentType
     *
     * @return Response
     */
    private function createResponse($data, $contentType)
    {
        return (new Response())
            ->setContent($data)
            ->setHeader('Content-Type', $contentType);
    }

    /**
     * @param string  $uri
     * @param integer $statusCode
     *
     * @return \Brick\Http\Response
     */
    protected function redirect($uri, $statusCode = 302)
    {
        return (new Response())
            ->setStatusCode($statusCode)
            ->setHeader('Location', $uri);
    }
}