<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTest extends TestCase
{
	use RefreshDatabase;

	public function testHome()
	{
		$response = $this->get('/');

		$response->assertStatus(200);
	}
}
