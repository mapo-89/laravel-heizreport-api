<?php

namespace Mapo89\LaravelHeizreportApi\Tests\Unit;

use Mapo89\LaravelHeizreportApi\Tests\TestCase;
use Illuminate\Support\Collection;
use Mapo89\LaravelHeizreportApi\Api\Projects;

class ProjectsTest extends TestCase
{
    /** @test */
    public function it_returns_projects_collection()
    {
        // ⛳ Anonyme Klasse, die execute() überschreibt
        $mockedProjects = [
            'projekte' => [
                ['id' => 1, 'name' => 'Projekt Alpha'],
                ['id' => 2, 'name' => 'Projekt Beta'],
            ]
        ];

        $projects = new class($mockedProjects) extends Projects {
            protected $mockData;

            public function __construct($mockData)
            {
                $this->mockData = $mockData;
                parent::__construct();
            }

            public function _get($url = null, $parameters = [])
            {
                return $this->mockData;
            }
        };

        $result = $projects->all();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->has('projekte'));
        $this->assertCount(2, $result['projekte']);
        $this->assertEquals('Projekt Alpha', $result['projekte'][0]['name']);
    }

    /** @test */
    public function it_returns_archived_projects_collection()
    {
        $mockedData = [
            'archiv' => [
                ['id' => 10, 'name' => 'Archiv Projekt X'],
            ]
        ];

        $projects = new class($mockedData) extends Projects {
            protected $mockData;
            public function __construct($mockData)
            {
                $this->mockData = $mockData;
                parent::__construct();
            }

            public function _get($url = null, $parameters = [])
            {
                return $this->mockData;
            }
        };

        $result = $projects->allArchived();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result['projekte']);
        $this->assertEquals('Archiv Projekt X', $result['projekte'][0]['name']);
    }

    /** @test */
    public function it_creates_project()
    {
        $mockedCreate = [
            'projektHeader' => ['key' => 'abc123']
        ];
        $mockedEdit = [
            'projektHeader' => ['key' => 'abc123'],
            'projektData' => ['name' => 'Neues Projekt']
        ];

        $projects = new class($mockedCreate, $mockedEdit) extends Projects {
            private $calls = 0;
            protected $createData;
            protected $editData;

            public function __construct($createData, $editData)
            {
                $this->createData = $createData;
                $this->editData = $editData;
                parent::__construct();
            }

            public function _get($url = null, $parameters = [])
            {
                return $this->calls++ === 0 ? $this->createData : $this->editData;
            }
        };

        $project = $projects->create(['name' => 'Test']);

        $this->assertEquals('abc123', $project->projektKey);
        $this->assertEquals('Neues Projekt', $project->projektData['name']);
    }

    /** @test */
    public function it_updates_project()
    {
        $mockedResponse = [
            'projektHeader' => ['key' => 'xyz999'],
            'projektData' => ['name' => 'Geändertes Projekt']
        ];

        $projects = new class($mockedResponse) extends Projects {
            protected $mock;
            public function __construct($mock)
            {
                $this->mock = $mock;
                parent::__construct();
            }

            public function _get($url = null, $parameters = [])
            {
                return $this->mock;
            }
        };

        $project = $projects->update('xyz999', ['name' => 'Geändert']);

        $this->assertEquals('xyz999', $project->projektKey);
        $this->assertEquals('Geändertes Projekt', $project->projektData['name']);
    }

    /** @test */
    public function it_returns_pdf_url_on_open_operation()
    {
        $mockedResponse = [
            'linkToDocument' => 'https://heizreport.de/pdfs/test123.pdf'
        ];

        $projects = new class($mockedResponse) extends Projects {
            protected $mock;
            public function __construct($mock)
            {
                $this->mock = $mock;
                parent::__construct();
            }

            public function _get($url = null, $parameters = [])
            {
                return $this->mock;
            }
        };

        $pdfUrl = $projects->handlePdf('abc', 'report.pdf', 'open');

        $this->assertEquals('https://heizreport.de/pdfs/test123.pdf', $pdfUrl);
    }
}
