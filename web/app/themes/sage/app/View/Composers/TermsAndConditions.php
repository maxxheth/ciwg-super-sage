<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TermsAndConditions extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'template-terms-conditions',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'pageData' => $this->getPageData(),
        ];
    }

    /**
     * Retrieves data for the Terms and Conditions page.
     *
     * @return array
     */
    protected function getPageData()
    {
        $post = get_post();

        // Default data structure
        $pageData = [
            'hero' => [
                'title'    => 'Terms and Conditions',
                'subtitle' => 'Please read these terms carefully before using our services.',
            ],
            'intro' => [
                'title'    => 'Website Terms of Use',
                'subtitle' => 'By accessing this website, you agree to be bound by these terms.',
            ],
            'terms_sections' => [
                [
                    'title'   => '1. Use of Website',
                    'content' => '<p>This website is intended to provide information about our landscaping services. The content is for informational purposes only and does not constitute a contract. Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.</p>',
                ],
                [
                    'title'   => '2. Intellectual Property',
                    'content' => '<p>All content included on this site, such as text, graphics, logos, and images, is the property of Sandoval Landscaping or its content suppliers and protected by international copyright laws. The compilation of all content on this site is the exclusive property of Sandoval Landscaping.</p>',
                ],
                [
                    'title'   => '3. Limitation of Liability',
                    'content' => '<p>Sandoval Landscaping will not be liable for any damages of any kind arising from the use of this site, including, but not limited to direct, indirect, incidental, punitive, and consequential damages. We do not warrant that this site, its servers, or e-mail sent from us are free of viruses or other harmful components.</p>',
                ],
                 [
                    'title'   => '4. Governing Law',
                    'content' => '<p>These terms and conditions are governed by and construed in accordance with the laws of the State of Texas and you irrevocably submit to the exclusive jurisdiction of the courts in that State or location.</p>',
                ],
            ],
            'contact_info' => [
                'email' => 'info@sandovallandscaping.com',
                'text'  => 'For any questions regarding these terms, please contact us at',
            ],
            'cta' => [
                'title'       => 'Do You Have Questions?',
                'description' => 'If you have any questions about our terms, services, or how we operate, please feel free to get in touch.',
                'buttonText'  => 'Contact Us',
                'buttonUrl'   => '/contact',
            ],
        ];

        // Overwrite with data from custom fields if Meta Box is active
        if ($post && function_exists('rwmb_meta')) {
            $pageData['hero']['title'] = rwmb_meta('hero_title', '', $post->ID) ?: $pageData['hero']['title'];
            $pageData['hero']['subtitle'] = rwmb_meta('hero_subtitle', '', $post->ID) ?: $pageData['hero']['subtitle'];

            $pageData['intro']['title'] = rwmb_meta('intro_title', '', $post->ID) ?: $pageData['intro']['title'];
            $pageData['intro']['subtitle'] = rwmb_meta('intro_subtitle', '', $post->ID) ?: $pageData['intro']['subtitle'];

            $sections = rwmb_meta('terms_sections', '', $post->ID);
            if (!empty($sections) && is_array($sections)) {
                $pageData['terms_sections'] = array_map(function ($section) {
                    return [
                        'title'   => $section['title'] ?? 'Section Title',
                        'content' => !empty($section['content']) ? wpautop($section['content']) : 'Section content missing.',
                    ];
                }, $sections);
            }
        }

        return $pageData;
    }
}