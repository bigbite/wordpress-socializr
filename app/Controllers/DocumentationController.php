<?php

namespace Socializr\Controllers;

class DocumentationController
{
    /**
     * Shows a 'Documentation currently under construction!' page.
     *
     * @throws \Herbert\Framework\Exceptions\HttpErrorException
     */
    public function get()
    {
        return view('@Socializr/docs.twig', [
            'section_title' => 'Documentation',
        ]);
    }
}
