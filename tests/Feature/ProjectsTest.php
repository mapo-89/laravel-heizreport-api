<?php

namespace Mapo89\LaravelHeizreportApi\Tests\Feature;

use GuzzleHttp\Psr7\Response;
use Mapo89\LaravelHeizreportApi\Api\Projects;
use Mapo89\LaravelHeizreportApi\Facades\HeizreportApi;
use Mapo89\LaravelHeizreportApi\Tests\Helpers\MockClientHelper;
use Orchestra\Testbench\TestCase;
use Mapo89\LaravelHeizreportApi\HeizreportApiServiceProvider;

class ProjectsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            HeizreportApiServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'HeizreportApi' => HeizreportApi::class,
        ];
    }

    /** @test */
    public function it_returns_all_projects_with_mocked_guzzle()
    {
        // Simuliere Guzzle-Antwort
        $mockResponses = [
            new Response(200, [], json_encode([
                'projekte' => [
                    ['id' => 1, 'name' => 'Fake Projekt A'],
                    ['id' => 2, 'name' => 'Fake Projekt B'],
                ]
            ])),
        ];

        $client = MockClientHelper::create($mockResponses);

        // Projects manuell instanziieren und den gefakten Client setzen
        $projects = new class($client) extends Projects {
            public function __construct($client)
            {
                parent::__construct();
                $this->client = $client;
            }
        };

        $result = $projects->all();

        $this->assertCount(2, $result['projekte']);
        $this->assertEquals('Fake Projekt A', $result['projekte'][0]['name']);
    }

    /** @test */
    public function it_returns_all_archived_projects()
    {
        $mockResponses = [
            new Response(200, [], json_encode([
                'archiv' => [
                    ['id' => 1, 'name' => 'Archiv Projekt A'],
                    ['id' => 2, 'name' => 'Archiv Projekt B'],
                ]
            ])),
        ];

        $client = MockClientHelper::create($mockResponses);

        $projects = new class($client) extends Projects {
            public function __construct($client)
            {
                parent::__construct();
                $this->client = $client;
            }
        };

        $result = $projects->allArchived();

        $this->assertCount(2, $result['projekte']);
        $this->assertEquals('Archiv Projekt A', $result['projekte'][0]['name']);
    }

    /** @test */
    public function it_creates_a_project()
    {
        $mockResponses = [
            new Response(200, [], json_encode([
                'projektHeader' => ['key' => '1234-abc']
            ])),
            new Response(200, [], json_encode([
                'projektHeader' => ['key' => '1234-abc'],
                'projektData' => ['title' => 'Mein Testprojekt']
            ])),
        ];

        $client = MockClientHelper::create($mockResponses);

        $projects = new class($client) extends Projects {
            public function __construct($client)
            {
                parent::__construct();
                $this->client = $client;
            }
        };

        $result = $projects->create(['title' => 'Mein Testprojekt']);

        $this->assertEquals('1234-abc', $result->projektKey);
        $this->assertEquals('Mein Testprojekt', $result->projektData['title']);
    }
    /** @test */
    public function it_updates_a_project()
    {
        $mockResponses = [
            // simulate editReportData call
            new Response(200, [], json_encode([
                'projektHeader' => ['key' => 'updated-key'],
                'projektData' => ['title' => 'Updated Projektname']
            ])),
        ];

        $client = MockClientHelper::create($mockResponses);

        $projects = new class($client) extends Projects {
            public function __construct($client)
            {
                parent::__construct();
                $this->client = $client;
            }
        };

        $result = $projects->update('updated-key', ['title' => 'Updated Projektname']);

        $this->assertEquals('updated-key', $result->projektKey);
        $this->assertEquals('Updated Projektname', $result->projektData['title']);
    }

    /** @test */
    public function it_returns_a_pdf_link()
    {
        $mockResponses = [
            new Response(200, [], json_encode([
                'linkToDocument' => 'https://heizreport.de/fake-pdf-link.pdf'
            ])),
        ];

        $client = MockClientHelper::create($mockResponses);

        $projects = new class($client) extends Projects {
            public function __construct($client)
            {
                parent::__construct();
                $this->client = $client;
            }
        };

        $result = $projects->handlePdf('test-key', 'filename.pdf', 'open');

        $this->assertEquals('https://heizreport.de/fake-pdf-link.pdf', $result);
    }

}
