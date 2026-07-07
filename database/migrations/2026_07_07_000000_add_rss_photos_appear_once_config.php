<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2026 LycheeOrg.
 */

use App\Models\Extensions\BaseConfigMigration;

return new class() extends BaseConfigMigration {
	public const CAT = 'Mod RSS';

	public function getConfigs(): array
	{
		return [
			[
				'key' => 'rss_photos_appear_once',
				'value' => '0',
				'cat' => self::CAT,
				'type_range' => self::BOOL,
				'is_secret' => false,
				'description' => 'Photos appear only once in RSS feed',
				'details' => 'Each photo will only appear once in the RSS feed, regardless of how many albums it belongs to.',
				'level' => 0,
				'order' => 32767,
				'is_expert' => false,
			],
		];
	}
};
