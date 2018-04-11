<?php

/**
 * This file is part of the contentful.php package.
 *
 * @copyright 2015-2018 Contentful GmbH
 * @license   MIT
 */

namespace Contentful\Tests\Delivery\Integration;

use Contentful\Delivery\Client;
use Contentful\Tests\Delivery\TestCase;

/**
 * The Contentful API differentiates between `null` and no value. For some fields this is rather rare as the web app
 * never sets the value to null. This test cases should cover these corner cases.
 */
class NullValueTest extends TestCase
{
    public function testNullAsValueForLink()
    {
        $client = new Client('irrelevant', 'rue07lqzt1co');

        $client->parseJson($this->getFixtureContent('space.json'));
        $client->parseJson($this->getFixtureContent('environment.json'));
        $client->parseJson($this->getFixtureContent('content_type.json'));
        $entry = $client->parseJson($this->getFixtureContent('entry.json'));

        $this->assertNull($entry->getLogo());
    }

    /**
     * @see https://github.com/contentful/contentful.php/issues/103
     * @see https://github.com/contentful/contentful.php/pull/122
     */
    public function testFieldIsPresentButEmpty()
    {
        $client = new Client('irrelevant', 'rue07lqzt1co');

        $client->parseJson($this->getFixtureContent('space.json'));
        $client->parseJson($this->getFixtureContent('environment.json'));
        $client->parseJson($this->getFixtureContent('content_type.json'));
        $entry = $client->parseJson($this->getFixtureContent('entry_field_without_values.json'));

        $this->assertNull($entry->get('logo'));
        $this->assertSame([], $entry->get('phone'));
    }
}
