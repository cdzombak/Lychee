<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
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

namespace Tests\Feature_v2\UserManagement;

use App\Models\User;
use Tests\Feature_v2\Base\BaseApiWithDataTest;

class DeleteUserTest extends BaseApiWithDataTest
{
	public function testDeleteUserGuest(): void
	{
		$response = $this->deleteJson('UserManagement');
		$this->assertUnprocessable($response);

		$response = $this->deleteJson('UserManagement', [
			'id' => $this->userMayUpload1->id,
		]);
		$this->assertUnauthorized($response);

		$response = $this->actingAs($this->userMayUpload2)->deleteJson('UserManagement', [
			'id' => $this->userMayUpload1->id,
		]);
		$this->assertForbidden($response);
	}

	public function testDeleteUserAdmin(): void
	{
		$num_users = User::count();
		$response = $this->actingAs($this->admin)->deleteJson('UserManagement', [
			'id' => $this->userNoUpload->id,
		]);
		$this->assertNoContent($response);
		self::assertEquals($num_users - 1, User::count());

		$response = $this->actingAs($this->admin)->getJson('UserManagement');
		$this->assertOk($response);
		$response->assertDontSee($this->userNoUpload->username);
	}
}