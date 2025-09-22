<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PrivacyPolicy extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'template-privacy-policy',
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

	protected function title()
	{
		return 'Privacy Policy';
	}


    /**
     * Retrieves data for the Privacy Policy page.
     *
     * @return array
     */
    protected function getPageData()
    {
        $post = get_post();

        // Default data structure
        $pageData = [
            'hero' => [
                'title'    => 'Privacy Policy',
                'subtitle' => 'Your privacy is important to us',
            ],
            'intro' => [
                'title'    => 'Our Commitment to Your Privacy',
                'subtitle' => 'Learn how we collect, use, and protect your information',
            ],
            'policy_sections' => [
                [
                    'title'   => 'Information We Collect',
                    'content' => '<ul><li>Personal information you provide via forms (name, email, phone, etc.).</li><li>Information collected automatically through cookies and server logs (IP address, browser type, etc.).</li><li>Usage data to help us improve our services.</li></ul>',
                ],
                [
                    'title'   => 'How We Use Your Information',
                    'content' => '<ul><li>To respond to your inquiries and provide the services you request.</li><li>To improve our website and customer experience.</li><li>For marketing and communication purposes, but only with your explicit consent.</li></ul>',
                ],
                [
                    'title'   => 'Data Protection and Your Rights',
                    'content' => '<ul><li>We implement security measures to protect your personal data.</li><li>You have the right to request access, correction, or deletion of your personal data.</li><li>You can opt out of marketing communications at any time.</li></ul>',
                ],
            ],
            'contact_info' => [
                'email' => 'info@sandovallandscaping.com',
                'text'  => 'For more information or to exercise your privacy rights, please contact us at',
            ],
            'cta' => [
                'title'       => 'Questions About Our Policy?',
                'description' => 'We are here to help. Contact us if you have any questions or concerns about how we handle your data.',
                'buttonText'  => 'Contact Us',
                'buttonUrl'   => '/contact',
            ],
        ];

        // Overwrite with data from custom fields if Meta Box is active
        if ($post && function_exists('rwmb_meta')) {
            // Hero section
            $pageData['hero']['title'] = rwmb_meta('hero_title', '', $post->ID) ?: $pageData['hero']['title'];
            $pageData['hero']['subtitle'] = rwmb_meta('hero_subtitle', '', $post->ID) ?: $pageData['hero']['subtitle'];

            // Intro section
            $pageData['intro']['title'] = rwmb_meta('intro_title', '', $post->ID) ?: $pageData['intro']['title'];
            $pageData['intro']['subtitle'] = rwmb_meta('intro_subtitle', '', $post->ID) ?: $pageData['intro']['subtitle'];

            // Policy Sections (assuming a cloneable group with 'title' and 'content' fields)
            $sections = rwmb_meta('policy_sections', '', $post->ID);
            if (!empty($sections) && is_array($sections)) {
                $pageData['policy_sections'] = array_map(function ($section) {
                    return [
                        'title'   => $section['title'] ?? 'Section Title',
                        'content' => !empty($section['content']) ? wpautop($section['content']) : 'Section content missing.',
                    ];
                }, $sections);
            }

            // Contact Info
            $pageData['contact_info']['email'] = rwmb_meta('contact_email', '', $post->ID) ?: $pageData['contact_info']['email'];
            $pageData['contact_info']['text'] = rwmb_meta('contact_text', '', $post->ID) ?: $pageData['contact_info']['text'];
            
            // CTA Section
            $pageData['cta']['title'] = rwmb_meta('cta_title', '', $post->ID) ?: $pageData['cta']['title'];
            $pageData['cta']['description'] = rwmb_meta('cta_description', '', $post->ID) ?: $pageData['cta']['description'];
            $pageData['cta']['buttonText'] = rwmb_meta('cta_button_text', '', $post->ID) ?: $pageData['cta']['buttonText'];
            $pageData['cta']['buttonUrl'] = rwmb_meta('cta_button_url', '', $post->ID) ?: $pageData['cta']['buttonUrl'];
        
		}

		return $pageData;

	}

}