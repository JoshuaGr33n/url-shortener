<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UrlShortenerService;
use Mockery;

class UrlShortenerTest extends TestCase
{
    // Mocked instance of UrlShortenerService
    protected $urlShortenerService;

    /**
     * Setup method for initializing the test environment.
     * Creates a mock instance of the UrlShortenerService.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock for the UrlShortenerService
        $this->urlShortenerService = Mockery::mock(UrlShortenerService::class);
        $this->app->instance(UrlShortenerService::class, $this->urlShortenerService);
    }

    /**
     * Test encoding a valid URL.
     * Ensures that the service returns a short key for the given URL.
     *
     * @return void
     */
    public function testItCanEncodeAUrl()
    {
        // Define expected behavior for the mock
        $this->urlShortenerService
            ->shouldReceive('encode')
            ->once()
            ->with('https://www.thisisalongdomain.com/with/some/parameters?and=here_too')
            ->andReturn('shortKey');

        // Send a POST request to the /api/encode endpoint
        $response = $this->postJson('/api/encode', ['url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too']);

        // Assert the response status and structure
        $response->assertStatus(200)
                 ->assertJsonStructure(['short_url']);
    }

    /**
     * Test decoding a short URL.
     * Ensures that the service returns the original URL for the given short key.
     *
     * @return void
     */
    public function testItCanDecodeAShortUrl()
    {
        // Define expected behavior for the mock
        $this->urlShortenerService
            ->shouldReceive('decode')
            ->once()
            ->with('shortKey')
            ->andReturn('https://www.thisisalongdomain.com/with/some/parameters?and=here_too');

        // Send a POST request to the /api/decode endpoint
        $response = $this->postJson('/api/decode', ['short_url' => 'shortKey']);

        // Assert the response status and content
        $response->assertStatus(200)
                 ->assertJson(['url' => 'https://www.thisisalongdomain.com/with/some/parameters?and=here_too']);
    }

    /**
     * Test encoding an invalid URL.
     * Ensures that the service returns an error for an invalid URL.
     *
     * @return void
     */
    public function testItReturnsErrorForInvalidUrlOnEncode()
    {
        // Send a POST request with an invalid URL
        $response = $this->postJson('/api/encode', ['url' => 'not-a-valid-url']);

        // Assert the response status and structure
        $response->assertStatus(422)
                 ->assertJsonStructure(['errors']);
    }

    /**
     * Test decoding an invalid short URL.
     * Ensures that the service returns an error when the short URL is not found.
     *
     * @return void
     */
    public function testItReturnsErrorForInvalidShortUrlOnDecode()
    {
        // Define expected behavior for the mock
        $this->urlShortenerService
            ->shouldReceive('decode')
            ->once()
            ->with('invalid_key')
            ->andReturn(null);

        // Send a POST request with an invalid short key
        $response = $this->postJson('/api/decode', ['short_url' => 'invalid_key']);

        // Assert the response status and content
        $response->assertStatus(404)
                 ->assertJson(['error' => 'Short URL not found']);
    }

    /**
     * Teardown method for cleaning up after the tests.
     * Closes the mockery instance.
     */
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
