<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Gallery extends Composer
{
	/**
	 * List of views served by this composer.
	 *
	 * @var array
	 */
	protected static $views = [
		'components.gallery',
	];

	/**
	 * Data to be passed to view before rendering.
	 *
	 * @return array
	 */
	public function with()
	{
		$galleryImages = $this->getGalleryImages();

		$captionMap = [
			'1-1600h' => "Mowing service completed in Rockwall, TX.",
		];

			

		$galleryCaptions = [];

		// Assign an index to each image and build the captions array.
		foreach ($galleryImages as $i => $image) {
			$imgName = $galleryImages[$i]['name'];

			$imgCaption =  $captionMap[$imgName] ?? "This is a caption for the image named $imgName.";

			$imgCaption = $imgCaption . " - Name: $imgName";
			$galleryCaptions[$imgName] = $imgCaption;

			// Dedupe $galleryCaptions
		}
		$galleryCaptions = array_unique($galleryCaptions);

		return [
			'galleryImages'   => $galleryImages,
			'galleryCaptions' => $galleryCaptions,
			'showCaptions' => true,
		];
	}

	/**
	 * Scan the gallery directory and get image data.
	 *
	 * @return array
	 */
	public function getGalleryImages($directory = null)
	{
		// Default to theme gallery directory if not specified
		if (is_null($directory)) {
			$galleryPath = get_theme_file_path('resources/images/gallery');
			$galleryUrl  = get_theme_file_uri('resources/images/gallery');
		} else {
			$galleryPath = get_theme_file_path('resources/images/' . $directory);
			$galleryUrl  = get_theme_file_uri('resources/images/' . $directory);
		}

		// Check if directory exists
		if (!is_dir($galleryPath)) {
			return [];
		}

		$files  = scandir($galleryPath);
		$images = [];

		foreach ($files as $file) {
			// Skip directories and non-image files
			if (in_array($file, ['.', '..']) || is_dir($galleryPath . '/' . $file)) {
				continue;
			}

			$extension = pathinfo($file, PATHINFO_EXTENSION);
			if (!in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
				continue;
			}

			$name     = pathinfo($file, PATHINFO_FILENAME);
			$fullPath = $galleryPath . '/' . $file;
			$url      = $galleryUrl . '/' . $file;

			// Get image dimensions
			$dimensions = getimagesize($fullPath);
			if ($dimensions) {
				$width  = $dimensions[0];
				$height = $dimensions[1];

				// Create thumbnail URL if available (assuming -thumb suffix convention)
				$thumbName = $name . '-thumb.' . $extension;
				$thumbPath = $galleryPath . '/' . $thumbName;
				$thumbnailUrl = file_exists($thumbPath)
					? $galleryUrl . '/' . $thumbName
					: $url;

				$images[] = [
					'name'         => $name,
					'filename'     => $file,
					'path'         => $fullPath,
					'url'          => $url,
					'thumbnailUrl' => $thumbnailUrl,
					'width'        => $width,
					'height'       => $height,
					'type'         => $extension,
					// Note: the caption will now come from a separate captions array.
				];
			}
		}

		return $images;
	}
}
