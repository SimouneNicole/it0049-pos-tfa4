<?php

namespace Tests\Feature;

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class RoutesTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomePageLoadsSuccessfully(): void
    {
        $result = $this->get('/');

        $result->assertOK();
        $result->assertSee('Point of Sale');
        $result->assertSee('Customer and staff records, kept in one clear place.');
        $result->assertSee('POS');
    }

    public function testAboutPageLoadsSuccessfully(): void
    {
        $result = $this->get('about');

        $result->assertOK();
        $result->assertSee('About');
        $result->assertSee('A simple place to view customer contact details and staff roles.');
        $result->assertSee('POS');
    }

    public function testCustomersPageLoadsWithRecords(): void
    {
        $result = $this->get('customers');

        $result->assertOK();
        $result->assertSee('Customer Accounts');
        $result->assertSee('Full name');
        $result->assertSee('Email address');
        $result->assertSee('Phone number');
        $result->assertSee('Eleanor Vance');
        $result->assertSee('eleanor.vance@example.com');
        $result->assertSee('+1 (555) 234-5678');
        $result->assertSee('Julian Hayes');
    }

    public function testUsersPageLoadsWithRecords(): void
    {
        $result = $this->get('users');

        $result->assertOK();
        $result->assertSee('User Accounts');
        $result->assertSee('Username');
        $result->assertSee('Full name');
        $result->assertSee('Role');
        $result->assertSee('clara.delgado');
        $result->assertSee('Clara Delgado');
        $result->assertSee('System Administrator');
        $result->assertSee('Store Manager');
    }

    public function testNonExistentRouteThrowsPageNotFoundException(): void
    {
        $this->expectException(PageNotFoundException::class);
        $this->get('non-existent-page-route');
    }
}
