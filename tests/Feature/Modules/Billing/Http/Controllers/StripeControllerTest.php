<?php

namespace Tests\Feature\Modules\Billing\Http\Controllers;

use Tests\TestCase;

/**
 * @see \Modules\Billing\Http\Controllers\StripeController
 */
class StripeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function stripe_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->get(route('stripe', ['id' => $id]));

        $response->assertOk();

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function stripe_post_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $response = $this->post(route('stripe.post'), [
            // TODO: send request data
        ]);

        $response->assertOk();

        // TODO: perform additional assertions
    }

    // test cases...
}