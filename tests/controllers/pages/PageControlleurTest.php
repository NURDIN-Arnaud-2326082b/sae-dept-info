<?php

use PHPUnit\Framework\TestCase;
use App\src\controllers\pages\PageControlleur;
use App\src\models\PageModel;
use App\src\models\UserModel;
use App\src\views\pages\Show;

class PageControlleurTest extends TestCase
{
    private PageControlleur $controller;
    private $mockPageModel;
    private $mockUserModel;
    private $mockShow;

    protected function setUp(): void
    {
        $this->mockPageModel = $this->createMock(PageModel::class);
        $this->mockUserModel = $this->createMock(UserModel::class);
        $this->mockShow = $this->createMock(Show::class);

        $this->controller = new PageControlleur('TestPage');
        $this->controller->pageModel = $this->mockPageModel;
        $this->controller->userModel = $this->mockUserModel;
    }

    public function testGenererTitre(): void
    {
        $this->mockPageModel->expects($this->once())
            ->method('genererTitre')
            ->with('TestPage')
            ->willReturn(['Generated Title']);

        $result = $this->controller->genererTitre();

        $this->assertEquals(['Generated Title'], $result);
    }

    public function testGenererContenu(): void
    {
        $this->mockPageModel->expects($this->once())
            ->method('genererContenu')
            ->with('TestPage')
            ->willReturn(['Generated Content']);

        $result = $this->controller->genererContenu();

        $this->assertEquals(['Generated Content'], $result);
    }

    public function testUpdateArticleAction(): void
    {
        $_POST = [
            'id' => '1',
            'titre' => 'New Title',
            'contenu' => 'New Content',
            'lien' => 'http://example.com',
            'name' => 'TestPage'
        ];

        $this->mockPageModel->expects($this->once())
            ->method('updateArticleAction')
            ->with('1', 'New Title', 'New Content', 'http://example.com');

        $this->expectOutputString('');
        $this->controller->updateArticleAction();
    }

    public function testDeleteArticleAction(): void
    {
        $_POST = [
            'delete' => '1',
            'type' => 'testType',
            'name' => 'TestPage'
        ];

        $this->mockPageModel->expects($this->once())
            ->method('deleteArticleAction')
            ->with('1', 'testType');

        $this->expectOutputString('');
        $this->controller->deleteArticleAction();
    }

    public function testAjouterArticleAction(): void
    {
        $_POST = [
            'type' => 'menu',
            'name' => 'TestPage'
        ];

        $this->mockPageModel->expects($this->once())
            ->method('ajouterPage')
            ->with('Menu', 'menu');

        $this->expectOutputString('');
        $this->controller->ajouterArticleAction();
    }

    public function testRecupererListe(): void
    {
        $mockData = [
            ['type' => 'list1'],
            ['type' => 'lstlinked1'],
            ['type' => 'list2']
        ];

        $this->mockPageModel->method('recupererType')
            ->with('TestPage')
            ->willReturn($mockData);

        $result = $this->controller->recupererListe();

        $this->assertEquals(['cpt' => 3, 'cpt2' => 2], $result);
    }

    public function testGetImage(): void
    {
        $_GET = ['id' => '1'];
        $mockImageData = ['type' => 'image/png', 'image' => 'binarydata'];

        $this->mockPageModel->method('getImageById')
            ->with('1')
            ->willReturn($mockImageData);

        $this->expectOutputString('binarydata');
        $this->controller->getImage();
    }

    /**
     * @throws Exception
     */
    public function testUpdateImageAction(): void
    {
        $_POST = [
            'id' => '1',
            'name' => 'TestPage'
        ];
        $_FILES = [
            'image' => [
                'tmp_name' => '/tmp/phpfile',
                'error' => UPLOAD_ERR_OK
            ]
        ];

        $this->mockPageModel->expects($this->any())
            ->method('updateImageById')
            ->with('1', $this->anything(), $this->anything());

        $this->expectOutputString('');
        $this->controller->updateImageAction();
    }

    public function testGetPdf(): void
    {
        $_GET = ['id' => '1'];
        $mockPdfData = ['type' => 'application/pdf', 'data' => 'binarypdfdata'];

        $this->mockPageModel->method('getPdfById')
            ->with('1')
            ->willReturn($mockPdfData);

        $this->expectOutputString('binarypdfdata');
        $this->controller->getPdf();
    }

    public function testUpdatePdfAction(): void
    {
        $_POST = [
            'id' => '1',
            'name' => 'TestPage'
        ];
        $_FILES = [
            'file' => [
                'tmp_name' => '/tmp/phpfile',
                'error' => UPLOAD_ERR_OK
            ]
        ];

        $this->mockPageModel->expects($this->any())
            ->method('updatePdfById')
            ->with('1', $this->anything(), $this->anything());

        $this->expectOutputString('');
        $this->controller->updatePdfAction();
    }

    public function testAjouterUserAction(): void
    {
        $_POST = [
            'page' => 'TestPage',
            'name' => 'TestUser',
            'email' => 'test@example.com',
            'annee' => '2023',
            'groupe' => 'A'
        ];

        $this->mockUserModel->expects($this->once())
            ->method('ajouterUserAction')
            ->with('TestUser', 'test@example.com', '2023', 'A');

        $this->expectOutputString('');
        $this->controller->ajouterUserAction();
    }

    public function testSupprimerUserAction(): void
    {
        $_POST = [
            'page' => 'TestPage',
            'email' => 'test@example.com'
        ];

        $this->mockUserModel->expects($this->once())
            ->method('supprimerUserAction')
            ->with('test@example.com');

        $this->expectOutputString('');
        $this->controller->supprimerUserAction();
    }

    public function testMettreAjourMdpAction(): void
    {
        $_POST = [
            'name' => 'TestUser',
            'mdp' => 'newpassword'
        ];

        $this->mockUserModel->expects($this->once())
            ->method('mettreAjourMdpAction')
            ->with('TestUser', 'newpassword');

        $this->expectOutputString('');
        $this->controller->mettreAjourMdpAction();
    }

    public function testEstConnecte(): void
    {
        $this->mockPageModel->method('estConnecte')
            ->with('TestUser')
            ->willReturn(true);

        $result = $this->controller->estConnecte('TestUser');

        $this->assertTrue($result);
    }

    public function testDeleteImageAction(): void
    {
        $_POST = [
            'delete' => '1',
            'name' => 'TestPage'
        ];

        $this->mockPageModel->expects($this->once())
            ->method('deleteImageAction')
            ->with('1');

        $this->expectOutputString('');
        $this->controller->deleteImageAction();
    }
}
