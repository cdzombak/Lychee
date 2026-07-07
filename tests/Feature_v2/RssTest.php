<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2026 LycheeOrg.
 */

/**
 * We don't care for unhandled exceptions in tests.
 * It is the nature of a test to throw an exception.
 * Without this suppression we had 100+ Linter warning in this file which
 * don't help anything.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

namespace Tests\Feature_v2;

use App\Models\Configs;
use App\Models\Photo;
use App\Repositories\ConfigManager;
use Exception;
use Tests\Feature_v2\Base\BaseApiWithDataTest;

class RssTest extends BaseApiWithDataTest
{
	public function testRSS0(): void
	{
		$config_manager = resolve(ConfigManager::class);
		// save initial value
		$init_config_value = $config_manager->getValue('rss_enable');

		try {
			// set to 0
			Configs::set('rss_enable', '0');

			// check redirection
			$response = $this->get('/feed');
			$this->assertStatus($response, 412);
		} catch (\Exception $e) {
			// handle exception
			$this->assertTrue(false, 'Exception occurred: ' . $e->getMessage());
		} finally {
			Configs::set('rss_enable', $init_config_value);
		}
	}

	public function testRSS1(): void
	{
		// save initial value
		$config_manager = resolve(ConfigManager::class);
		$init_config_value = $config_manager->getValue('rss_enable');

		try {
			// set to 1
			Configs::set('rss_enable', '1');

			// check redirection
			$response = $this->get('/feed');
			$this->assertOk($response);
		} catch (\Exception $e) {
			// handle exception
			$this->assertTrue(false, 'Exception occurred: ' . $e->getMessage());
		} finally {
			Configs::set('rss_enable', $init_config_value);
		}
	}

	/**
	 * A single photo (one row in `photos`) that belongs to two albums (two rows
	 * in `photo_album`) must appear exactly once per album in the RSS feed.
	 */
	public function testRSSPhotoInMultipleAlbumsIsNotDuplicated(): void
	{
		$config_manager = resolve(ConfigManager::class);
		$init_config_value = $config_manager->getValue('rss_enable');

		try {
			Configs::set('rss_enable', '1');

			// One photo, two album memberships.
			$photo = Photo::factory()
				->owned_by($this->admin)
				->in($this->album1)
				->create();
			$photo->albums()->attach($this->album2->id);

			$response = $this->actingAs($this->admin)->get('/feed');
			$this->assertOk($response);
			$content = $response->getContent();

			// `<guid>` is rendered exactly once per feed item, so it is a reliable
			// per-item marker (the page link itself also appears in `<link>`).
			$guid_album1 = '<guid>' . route('gallery', ['albumId' => $this->album1->id, 'photoId' => $photo->id]) . '</guid>';
			$guid_album2 = '<guid>' . route('gallery', ['albumId' => $this->album2->id, 'photoId' => $photo->id]) . '</guid>';

			// The photo is in two albums, so it must appear exactly once per album.
			$this->assertSame(1, substr_count($content, $guid_album1), 'photo should appear once for album1');
			$this->assertSame(1, substr_count($content, $guid_album2), 'photo should appear once for album2');
		} catch (\Exception $e) {
			$this->assertTrue(false, 'Exception occurred: ' . $e->getMessage());
		} finally {
			Configs::set('rss_enable', $init_config_value);
		}
	}

	/**
	 * With `rss_photos_appear_once` enabled, a photo that belongs to several
	 * albums must appear exactly once in the whole feed, but that single item
	 * must list every album it belongs to as a `<category>`.
	 */
	public function testRSSPhotoInMultipleAlbumsAppearsOnceWhenConfigured(): void
	{
		$config_manager = resolve(ConfigManager::class);
		$init_rss_enable = $config_manager->getValue('rss_enable');
		$init_appear_once = $config_manager->getValue('rss_photos_appear_once');

		try {
			Configs::set('rss_enable', '1');
			Configs::set('rss_photos_appear_once', '1');

			// One photo, two album memberships.
			$photo = Photo::factory()
				->owned_by($this->admin)
				->in($this->album1)
				->create();
			$photo->albums()->attach($this->album2->id);

			$response = $this->actingAs($this->admin)->get('/feed');
			$this->assertOk($response);
			$content = $response->getContent();

			// Each feed item ends its `<guid>` with the photo id; the photo must
			// be present in exactly one item across the whole feed.
			$this->assertSame(1, substr_count($content, $photo->id . '</guid>'), 'photo should appear exactly once in the feed');

			// That single item must still carry both albums as categories, so no
			// album membership is lost by collapsing to one item.
			$this->assertStringContainsString('<category>' . $this->album1->title . '</category>', $content, 'feed should list album1 as a category');
			$this->assertStringContainsString('<category>' . $this->album2->title . '</category>', $content, 'feed should list album2 as a category');
		} catch (\Exception $e) {
			$this->assertTrue(false, 'Exception occurred: ' . $e->getMessage());
		} finally {
			Configs::set('rss_enable', $init_rss_enable);
			Configs::set('rss_photos_appear_once', $init_appear_once);
		}
	}
}